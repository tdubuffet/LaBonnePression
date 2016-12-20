<?php

namespace InstitutionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InstitutionBundle\Model\UID;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Institution
 *
 * @ORM\Table(name="institution")
 * @ORM\Entity(repositoryClass="InstitutionBundle\Repository\InstitutionRepository")
 */
class Institution
{

    use ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(
     *      min = "5",
     *      max = "200"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="little_description", type="string", length=100)
     * @Assert\Length(
     *      min = "10",
     *      max = "100"
     * )
     */
    private $littleDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(
     *      min = "50",
     *      max = "1000"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="institutions")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="formatted_address", type="text")
     */
    private $formattedAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="formatted_phone_number", type="string", length=255, unique=false, nullable=true)
     */
    private $formattedPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="formatted_international_phone_number", type="string", length=255, nullable=true)
     */
    private $formattedInternationalPhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=false, nullable=true)
     */
    private $email;


    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;


    /**
     * @var string
     *
     * @ORM\Column(name="city", type="text", nullable=true)
     */
    private $city;


    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="text", nullable=true)
     */
    private $postalCode;


    /**
     * @var float
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var float
     *
     * @ORM\Column(name="secret_code", type="string", length=8, nullable=false, unique=true)
     */
    private $secretCode = null;


    /**
     * @var string
     *
     * @ORM\Column(name="manager_name", type="string", length=100, nullable=true)
     * @Assert\Length(
     *      min = "5",
     *      max = "100"
     * )
     */
    private $managerName = null;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Account", inversedBy="institutions")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account = null;


    public function getSluggableFields()
    {
        return [ 'name', 'postalCode', 'city' ];
    }

    /** -----------
     * Google DATA
     * ------------/

     * /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true, unique=true)
     */
    private $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="google_place_id", type="string", length=255, nullable=true, unique=true)
     */
    private $googlePlaceId;

    /**
     * @var string
     *
     * @ORM\Column(name="google_reference", type="string", nullable=true, length=255, unique=true)
     */
    private $googleReference;

    /**
     * @var float
     *
     * @ORM\Column(name="google_rating", type="float", nullable=true)
     */
    private $googleRating;

    /**
     * @var int
     *
     * @ORM\Column(name="google_user_ratings_total", type="integer", nullable=true)
     */
    private $googleUserRatingsTotal;


    /**
     * @var float
     *
     * @ORM\Column(name="google_types", type="array", nullable=true)
     */
    private $googleTypes;


    /**
     * @var float
     *
     * @ORM\Column(name="google_address_components", type="array", nullable=true)
     */
    private $googleAddressComponents;

    /**
     * @ORM\Column(type="datetime", name="imported_at")
     */
    private $importedAt;

    public function __construct()
    {

        if($this->secretCode == null) {
            $code = new UID();

            $this->secretCode = $code->limit(8);
        }

        if($this->importedAt == null) {
            $this->importedAt = new \DateTime;
        }

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set googleId
     *
     * @param integer $googleId
     *
     * @return Institution
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return int
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Institution
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Institution
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set googleRating
     *
     * @param float $googleRating
     *
     * @return Institution
     */
    public function setGoogleRating($googleRating)
    {
        $this->googleRating = $googleRating;

        return $this;
    }

    /**
     * Get googleRating
     *
     * @return float
     */
    public function getGoogleRating()
    {
        return $this->googleRating;
    }

    /**
     * @return string
     */
    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    /**
     * @param string $formattedAddress
     */
    public function setFormattedAddress($formattedAddress)
    {
        $this->formattedAddress = $formattedAddress;
    }

    /**
     * @return string
     */
    public function getFormattedPhoneNumber()
    {
        return $this->formattedPhoneNumber;
    }

    /**
     * @param string $formattedPhoneNumber
     */
    public function setFormattedPhoneNumber($formattedPhoneNumber)
    {
        $this->formattedPhoneNumber = $formattedPhoneNumber;
    }

    /**
     * @return string
     */
    public function getFormattedInternationalPhoneNumber()
    {
        return $this->formattedInternationalPhoneNumber;
    }

    /**
     * @param string $formattedInternationalPhoneNumber
     */
    public function setFormattedInternationalPhoneNumber($formattedInternationalPhoneNumber)
    {
        $this->formattedInternationalPhoneNumber = $formattedInternationalPhoneNumber;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param float $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return int
     */
    public function getGooglePlaceId()
    {
        return $this->googlePlaceId;
    }

    /**
     * @param int $googlePlaceId
     */
    public function setGooglePlaceId($googlePlaceId)
    {
        $this->googlePlaceId = $googlePlaceId;
    }

    /**
     * @return string
     */
    public function getGoogleReference()
    {
        return $this->googleReference;
    }

    /**
     * @param string $googleReference
     */
    public function setGoogleReference($googleReference)
    {
        $this->googleReference = $googleReference;
    }

    /**
     * @return int
     */
    public function getGoogleUserRatingsTotal()
    {
        return $this->googleUserRatingsTotal;
    }

    /**
     * @param int $googleUserRatingsTotal
     */
    public function setGoogleUserRatingsTotal($googleUserRatingsTotal)
    {
        $this->googleUserRatingsTotal = $googleUserRatingsTotal;
    }

    /**
     * @return float
     */
    public function getGoogleTypes()
    {
        return $this->googleTypes;
    }

    /**
     * @param float $googleTypes
     */
    public function setGoogleTypes($googleTypes)
    {
        $this->googleTypes = $googleTypes;
    }

    /**
     * @return float
     */
    public function getGoogleAddressComponents()
    {
        return $this->googleAddressComponents;
    }

    /**
     * @param float $googleAddressComponents
     */
    public function setGoogleAddressComponents($googleAddressComponents)
    {
        $this->googleAddressComponents = $googleAddressComponents;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getLocation() {
        return $this->latitude . ',' . $this->longitude;
    }

    public function getPictures()
    {
        
    }

    /**
     * @return string
     */
    public function getSecretCode()
    {
        return $this->secretCode;
    }

    /**
     * @param string $secretCode
     */
    public function setSecretCode($secretCode = null)
    {
        if ($secretCode == null) {
            if ($this->secretCode == null) {
                $code = new UID();
                $this->secretCode = $code->limit(8);
            }
        } else {
            $this->secretCode = $secretCode;
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getManagerName()
    {
        return $this->managerName;
    }

    /**
     * @param string $managerName
     */
    public function setManagerName($managerName)
    {
        $this->managerName = $managerName;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }


    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getImportedAt()
    {
        return $this->importedAt;
    }

    /**
     * @param mixed $importedAt
     */
    public function setImportedAt($importedAt)
    {
        $this->importedAt = $importedAt;
    }

    /**
     * @return string
     */
    public function getLittleDescription()
    {
        return $this->littleDescription;
    }

    /**
     * @param string $littleDescription
     */
    public function setLittleDescription($littleDescription)
    {
        $this->littleDescription = $littleDescription;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}

