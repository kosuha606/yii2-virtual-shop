<?php

namespace app\virtualModels\Admin\Domains\Email;

class EmailDTO
{
    private $toEmail;

    private $fromEmail;

    private $bcc;

    private $subject;

    private $body;

    /**
     * @return mixed
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * @param mixed $toEmail
     * @return EmailDTO
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param mixed $fromEmail
     * @return EmailDTO
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param mixed $bcc
     * @return EmailDTO
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return EmailDTO
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return EmailDTO
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}