<?php
namespace AdminBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class CambioADolares extends Twig_Extension
{

    protected $container = null;
    protected $em = null;
    protected $trans = null;

    public function setContainer(ContainerInterface $container = null)
    {

        $this->container = $container;
        $this->em = $container->get("doctrine")->getManager();
        $this->trans = $container->get("translator");
    }

    public function __construct(Container $container = null)
    {
        $this->setContainer($container);
    }

    public function getFunctions()
    {

        return array(new Twig_SimpleFunction('cambioADolares', array($this, 'cambioADolares')));
    }

    public function cambioADolares($valor, $currency)
    {
        $respuesta = json_decode($this->llamarAPI("GET", "http://free.currencyconverterapi.com/api/v5/convert?q=USD_" . $currency . "&compact=y"), true);
        $precioDolarTRM = $respuesta["USD_" . $currency]['val'];
        $valorDolar = $valor / $precioDolarTRM;
        return $valorDolar;
    }

    public function getName()
    {
        return 'cambioADolares';
    }

    function llamarAPI($metodo, $url, $data = false)
    {
        $curl = curl_init();

        switch ($metodo) {
            case "GEST":
                curl_setopt($curl, CURLOPT_POST, 1);
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
