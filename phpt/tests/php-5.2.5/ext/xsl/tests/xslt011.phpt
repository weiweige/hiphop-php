--TEST--
Test 11: php:function Support
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
print "Test 11: php:function Support\n";
  Class foo {
       function foo() {}
       function __toString() { return "not a DomNode object";}
  }

$dom = new domDocument();
  $dom->load(dirname(__FILE__)."/xslt011.xsl");
  $proc = new xsltprocessor;
  $xsl = $proc->importStylesheet($dom);
  
  $xml = new DomDocument();
  $xml->load(dirname(__FILE__)."/xslt011.xml");
  $proc->registerPHPFunctions();
  print $proc->transformToXml($xml);
 
  function foobar($id, $secondArg = "" ) {
    if (is_array($id)) {
        return $id[0]->value . " - " . $secondArg;
    } else {
        return $id . " - " . $secondArg;
    }
  }
  function nodeSet($id = null) {
      if ($id and is_array($id)) {
          return $id[0];
      } else {
          $dom = new domdocument;
          $dom->loadXML("<root>this is from an external DomDocument</root>");
          return $dom->documentElement;
      }
  }
  function nonDomNode() {
    return  new foo();
  }
  
  class aClass {
    static function aStaticFunction($id) {
        return $id;
    }
  }
  
--EXPECTF--
Test 11: php:function Support

Warning: XSLTProcessor::transformToXml(): A PHP Object can not be converted to a XPath-string in %s on line 16
<?xml version="1.0"?>
foobar - secondArg
foobar - 
this is from an external DomDocument
from the Input Document
static

