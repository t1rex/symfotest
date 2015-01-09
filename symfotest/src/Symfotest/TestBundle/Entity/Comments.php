<?php

namespace Symfotest\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 */
class Comments
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mail_body;

    /**
     * @var \DateTime
     *
     */
    private $date;

    /**
     * @var string
     */
    private $site;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var integer
     */
    private $rating;

    /**
     * @var string
     */
    private $status;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comments
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comments
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Comments
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set rating
     *
     * @param \integer $rating
     * @return Comments
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return \integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Comments
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
    *
    */
    public function prepareURL()
    {
        if($this->getSite()) {
            $this->site = parse_url($this->getSite(), PHP_URL_HOST);
        }
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Comments
     */
    public function setMail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return 't1rex@ukr.net';
    }

    /**
     * Set mail_body
     *
     * @param string $mail_body
     * @return Comments
     */
    public function setMailBody($mail_body)
    {
        $this->email = $mail_body;

        return $this;
    }

    /**
     * Get mail_body
     *
     * @return string
     */
    public function getMailBody()
    {
        return $this->mail_body;
    }

}
