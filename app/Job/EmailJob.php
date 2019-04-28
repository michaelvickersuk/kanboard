<?php

namespace Kanboard\Job;

/**
 * Class EmailJob
 *
 * @package Kanboard\Job
 * @author  Frederic Guillot
 */
class EmailJob extends BaseJob
{
    /**
     * Set job parameters
     *
     * @access public
     * @param  string $recipientEmail
     * @param  string $recipientName
     * @param  string $subject
     * @param  string $html
     * @param  string $authorName
     * @param  string $authorEmail
     * @param  array  $headers
     * @return $this
     */
    public function withParams($recipientEmail, $recipientName, $subject, $html, $authorName, $authorEmail, array $headers = [])
    {
        $this->jobParams = [
            $recipientEmail,
            $recipientName,
            $subject,
            $html,
            $authorName,
            $authorEmail,
            $headers,
        ];
        return $this;
    }

    /**
     * Execute job
     *
     * @access public
     * @param  string $recipientEmail
     * @param  string $recipientName
     * @param  string $subject
     * @param  string $html
     * @param  string $authorName
     * @param  string $authorEmail
     * @param  array  $headers
     */
    public function execute($recipientEmail, $recipientName, $subject, $html, $authorName, $authorEmail, array $headers = [])
    {
        $transport = $this->helper->mail->getMailTransport();
        $startTime = microtime(true);

        $this->logger->debug(__METHOD__.' Sending email to: '.$recipientEmail.' using transport: '.$transport);

        $this->emailClient
            ->getTransport($transport)
            ->sendEmail($recipientEmail, $recipientName, $subject, $html, $authorName, $authorEmail, $headers);

        $this->logger->debug(__METHOD__.' Email sent in '.round(microtime(true) - $startTime, 6).' seconds');
    }
}
