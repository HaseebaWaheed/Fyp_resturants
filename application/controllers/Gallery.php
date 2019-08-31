<?php

class gallery extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var integer $id
     *
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $image
     *
     * @Column(type="string", length=191)
     */
    private $image;

    /**
     * @var integer $module_id
     *
     * @Column(type="integer", columnDefinition="INT(11) NOT NULL AFTER image")
     */
    private $module_id;

   
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * @param int $module_id
     */
    public function setModuleId($module_id)
    {
        $this->module_id = $module_id;
    }


    public function savegallery()
    {
        $this->db->insert('galleries', array(
            "image" => $this->getImage(),
            "product_id" => $this->getModuleId()
        ));
    }
}