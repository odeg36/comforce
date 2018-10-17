<?php
namespace LogicBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use LogicBundle\Entity\Proceso;

class ProcesoListener
{

    public function prePersist(LifecycleEventArgs $args)
    {
        $proceso = $args->getEntity();
        if (!($proceso instanceof Proceso)) {
            return;
        }
        $em = $args->getObjectManager();
        $ultimoProceso = $em->getRepository('LogicBundle:Proceso')
            ->findOneBy(
            [], ['id' => 'DESC'], 0, 1
        );
        $ultimoNumeroProceso = $ultimoProceso != null ? $ultimoProceso->getNumeroProceso() + 1 : 1;
        $caracteres = 8;
        $numeroProceso = substr("00000000{$ultimoNumeroProceso}", -$caracteres);
        $proceso->setNumeroProceso($numeroProceso);
    }
}
