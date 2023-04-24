<?php
namespace MageDev\DevTools\Model;

class Layout implements \Magento\Framework\Event\ObserverInterface
{
    protected $_request;
    protected $_directoryList;
    protected $_config;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \MageEasy\DevTools\Helper\Config $config
    ) {

        $this->_request = $request;
        $this->_directoryList = $directoryList;
        $this->_config = $config;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_config->isLayoutLoggerEnabled()) {

            $path = $this->_directoryList->getPath('log') . "/layouts/";

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $file = $path . $this->getRouteNameAsFileName();
            if (file_exists($file)) {
                unlink($file);
            }

            # todo: Read the xml and remove duplicate nodes
            # todo: create a streamlined xml file and a raw xml file. 2 files with the same content in case you need to have a look at the raw file

            $xml = '<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="../../../../../../../lib/internal/Magento/Framework/View/Layout/etc/page_configuration.xsd">' . $observer->getEvent()->getLayout()->getXmlString() . '</page>';
            $this->writeXMLtoFile($xml, $file);
        }

        return $this;
    }

    private function getRouteNameAsFileName()
    {

        $moduleName = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();

        return $moduleName . '_' . $controller . '_' . $action . '.xml';
    }

    private function writeXMLtoFile($xml, $file)
    {


        $xmlObject = simplexml_load_string($xml);
        $xmlString = '';
        foreach ($xmlObject->layout as $key => $Item) {
            //Now you can access the 'row' data using $Item in this case
            //two elements, a name and an array of key/value pairs
            $xmlString .= $Item->Name;
            //Loop through the attribute array to access the 'fields'.
            foreach ($Item->Attribute as $Attribute) {
                //Each attribute has two elements, name and value.
                //echo $Attribute->Name . ": " . $Attribute->Value;
            }
        }

        $fopen = fopen($file, 'a+');
        fwrite($fopen, $xmlObject->asXML() . PHP_EOL);
        fclose($fopen);
    }
}
