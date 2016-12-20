<?php

namespace UserBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;


    /** @ORM\Column(name="twitter_id", type="string", length=255, nullable=true) */
    protected $twitter_id;

    /** @ORM\Column(name="twitter_access_token", type="string", length=255, nullable=true) */
    protected $twitter_access_token;


    /**
     * @ORM\Column(name="firstname", type="string", length=55, nullable=true)
     * @Assert\Length(
     *      min = "3",
     *      max = "55"
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=55, nullable=true)
     * @Assert\Length(
     *      min = "3",
     *      max = "55"
     * )
     */
    protected $lastname;


    /** @ORM\Column(name="avatar_social_network", type="string", length=255, nullable=true) */
    protected $avatarSocialNetwork;

    /** @ORM\Column(name="gravatar", type="string", length=255, nullable=true) */
    protected $gravatar;

    /** @ORM\Column(name="avatar", type="string", length=255, nullable=true) */
    protected $avatar;

    /**
     * @ORM\OneToMany(targetEntity="InstitutionBundle\Entity\Institution", mappedBy="account")
     */
    private $institutions;

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * @param mixed $facebook_access_token
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param mixed $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * @return mixed
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @param mixed $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * @return mixed
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * @param mixed $twitter_id
     */
    public function setTwitterId($twitter_id)
    {
        $this->twitter_id = $twitter_id;
    }

    /**
     * @return mixed
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * @param mixed $twitter_access_token
     */
    public function setTwitterAccessToken($twitter_access_token)
    {
        $this->twitter_access_token = $twitter_access_token;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {


        if ($this->avatar) {
            return $this->avatar;
        }

        if ($this->avatarSocialNetwork) {
            return $this->avatarSocialNetwork;
        }

        if ($this->gravatar) {
            return $this->gravatar;
        }

        return null;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getAvatarSocialNetwork()
    {
        return $this->avatarSocialNetwork;
    }

    /**
     * @param mixed $avatarSocialNetwork
     */
    public function setAvatarSocialNetwork($avatarSocialNetwork)
    {
        $this->avatarSocialNetwork = $avatarSocialNetwork;
    }

    /**
     * @return mixed
     */
    public function getGravatar()
    {
        return $this->gravatar;
    }

    /**
     * @param mixed $gravatar
     */
    public function setGravatar($gravatar)
    {
        $this->gravatar = $gravatar;
    }

    /**
     * @return mixed
     */
    public function getInstitutions()
    {
        return $this->institutions;
    }

    /**
     * @param mixed $institutions
     */
    public function setInstitutions($institutions)
    {
        $this->institutions = $institutions;
    }
}