<?php
namespace LogicBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Imagen
 *
 * @ORM\Table(name="imagen")
 * @ORM\Entity(repositoryClass="LogicBundle\Repository\ImagenRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Imagen
{

    const SERVER_PATH_TO_IMAGE_FOLDER = 'upload/';

    public function __toString()
    {
        return $this->nombre_archivo ? $this->nombre_archivo : '';
    }

    /**
     * Unmapped property to handle file uploads
     */
    private $archivo;

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
     * @ORM\Column(name="nombre_archivo", type="string", length=255)
     */
    private $nombre_archivo;

    /**
     * @ORM\ManyToOne(targetEntity="Disciplina", inversedBy="imagenes");
     * @ORM\JoinColumn(name="disciplina_id", referencedColumnName="id",  nullable=true)
     */
    private $disciplina;

    /**
     * @var \DateTime $fechaCreacion
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="fecha_creacion", type="date")
     */
    protected $fechaCreacion;

    /**
     * @var \DateTime $fechaActualizacion
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="fecha_actualizacion", type="date")
     */
    protected $fechaActualizacion;

    /**
     * Sets file.
     *
     * @param UploadedFile $archivo
     */
    public function setArchivo(UploadedFile $archivo = null)
    {
        $this->archivo = $archivo;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getArchivo()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and target filename as params
        $this->getArchivo()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER, $this->getArchivo()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->nombre_archivo = $this->getArchivo()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setArchivo(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     * 
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setFechaActualizacion(new \DateTime());
    }
    //**** FIN MODIFICACIONES ***//

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
     * Set nombreArchivo
     *
     * @param string $nombreArchivo
     *
     * @return Imagen
     */
    public function setNombreArchivo($nombreArchivo)
    {
        $this->nombre_archivo = $nombreArchivo;

        return $this;
    }

    /**
     * Get nombreArchivo
     *
     * @return string
     */
    public function getNombreArchivo()
    {
        return $this->nombre_archivo;
    }

    /**
     * Set fechaCreacion
     *
     * @param DateTime $fechaCreacion
     *
     * @return Imagen
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param DateTime $fechaActualizacion
     *
     * @return Imagen
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * Set disciplina
     *
     * @param Disciplina $disciplina
     *
     * @return Imagen
     */
    public function setDisciplina(Disciplina $disciplina = null)
    {
        $this->disciplina = $disciplina;

        return $this;
    }

    /**
     * Get disciplina
     *
     * @return Disciplina
     */
    public function getDisciplina()
    {
        return $this->disciplina;
    }
}
