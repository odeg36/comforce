<?php

namespace ServicesBundle\Tools;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Description of ResponseBuilder
 *
 * @author mherran
 */
class ResponseBuilder {

    public static function getCollection(\Symfony\Component\HttpFoundation\Request $request, $entityManager, $dql, $parameters = array()) {
        $pagina = $request->get('pagina', 1);
        $elementos_por_pagina = $request->get('elementos_por_pagina', 10);
        $query = $entityManager->createQuery($dql);
        if ($elementos_por_pagina > 0) {
            $query->setFirstResult(($pagina - 1) * $elementos_por_pagina);
            $query->setMaxResults($elementos_por_pagina);
        }

        foreach ($parameters as $name => $value) {
            $query->setParameter($name, $value);
        }
        $paginator = new Paginator($query, $fetchJoinCollection = false);

        $c = count($paginator);
        $data = array(
            'totalItems' => $c,
            'pagina' => $pagina,
            'elementos_por_pagina' => $elementos_por_pagina,
            'items' => $paginator->getIterator()->getArrayCopy()
        );
        return $data;
    }

    public static function getItem($entityManager, $dql, $parameters) {

        $query = $entityManager->createQuery($dql);
        foreach ($parameters as $name => $value) {
            $query->setParameter($name, $value);
        }
        $item = $query->getOneOrNullResult();
        return $item;
    }

}
