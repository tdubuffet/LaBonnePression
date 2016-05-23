<?php

namespace InstitutionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Institution
 *
 * @ORM\Table(name="institution")
 * @ORM\Entity(repositoryClass="InstitutionBundle\Repository\InstitutionRepository")
 */
class Institution
{
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

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

}

