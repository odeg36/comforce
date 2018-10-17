<?php
namespace LogicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Proceso
 *
 * @ORM\Table(name="proceso")
 * @ORM\Entity(repositoryClass="LogicBundle\Repository\ProcesoRepository")
 */
class Proceso
{

    public function __toString()
    {
        return $this->id ? $this->id : '';
    }

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
     * @ORM\Column(name="numero_proceso", type="string", length=8, unique=true)
     */
    private $numeroProceso;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=2000)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="presupuesto", type="integer")
     */
    private $presupuesto;

    /**
     * @ORM\ManyToOne(targetEntity="Sede", inversedBy="procesos");
     * @ORM\JoinColumn(name="sede_id", referencedColumnName="id",  nullable=true)
     */
    private $sede;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numeroProceso
     *
     * @param string $numeroProceso
     *
     * @return Proceso
     */
    public function setNumeroProceso($numeroProceso)
    {
        $this->numeroProceso = $numeroProceso;

        return $this;
    }

    /**
     * Get numeroProceso
     *
     * @return string
     */
    public function getNumeroProceso()
    {
        return $this->numeroProceso;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Proceso
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set presupuesto
     *
     * @param integer $presupuesto
     *
     * @return Proceso
     */
    public function setPresupuesto($presupuesto)
    {
        $this->presupuesto = $presupuesto;

        return $this;
    }

    /**
     * Get presupuesto
     *
     * @return integer
     */
    public function getPresupuesto()
    {
        return $this->presupuesto;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Proceso
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return Proceso
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * Set sede
     *
     * @param \LogicBundle\Entity\Sede $sede
     *
     * @return Proceso
     */
    public function setSede(\LogicBundle\Entity\Sede $sede = null)
    {
        $this->sede = $sede;

        return $this;
    }

    /**
     * Get sede
     *
     * @return \LogicBundle\Entity\Sede
     */
    public function getSede()
    {
        return $this->sede;
    }
}
