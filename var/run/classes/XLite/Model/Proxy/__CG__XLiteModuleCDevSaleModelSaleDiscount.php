<?php

namespace XLite\Model\Proxy\__CG__\XLite\Module\CDev\Sale\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class SaleDiscount extends \XLite\Module\CDev\Sale\Model\SaleDiscount implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array<string, null> properties to be lazy loaded, indexed by property name
     */
    public static $lazyPropertiesNames = array (
);

    /**
     * @var array<string, mixed> default values of properties to be lazy loaded, with keys being the property names
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array (
);



    public function __construct(?\Closure $initializer = null, ?\Closure $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', [$name]);

        return parent::__get($name);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', [$name, $value]);

        return parent::__set($name, $value);
    }

    /**
     * {@inheritDoc}
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__isset', [$name]);

        return parent::__isset($name);

    }

    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'useCustomOG', 'ogMeta', 'id', 'enabled', 'value', 'dateRangeBegin', 'dateRangeEnd', 'showInSeparateSection', 'metaDescType', 'specificProducts', 'productClasses', 'memberships', 'categories', 'saleDiscountProducts', 'cleanURLs', 'editLanguage', 'translations', '_previous_state'];
        }

        return ['__isInitialized__', 'useCustomOG', 'ogMeta', 'id', 'enabled', 'value', 'dateRangeBegin', 'dateRangeEnd', 'showInSeparateSection', 'metaDescType', 'specificProducts', 'productClasses', 'memberships', 'categories', 'saleDiscountProducts', 'cleanURLs', 'editLanguage', 'translations', '_previous_state'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (SaleDiscount $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getOpenGraphMetaTags($preprocessed = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOpenGraphMetaTags', [$preprocessed]);

        return parent::getOpenGraphMetaTags($preprocessed);
    }

    /**
     * {@inheritDoc}
     */
    public function setUseCustomOG($useCustomOG)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUseCustomOG', [$useCustomOG]);

        return parent::setUseCustomOG($useCustomOG);
    }

    /**
     * {@inheritDoc}
     */
    public function getUseCustomOG()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUseCustomOG', []);

        return parent::getUseCustomOG();
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isActive', []);

        return parent::isActive();
    }

    /**
     * {@inheritDoc}
     */
    public function isStarted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isStarted', []);

        return parent::isStarted();
    }

    /**
     * {@inheritDoc}
     */
    public function isExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isExpired', []);

        return parent::isExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function isApplicableForProduct(\XLite\Model\Product $product)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isApplicableForProduct', [$product]);

        return parent::isApplicableForProduct($product);
    }

    /**
     * {@inheritDoc}
     */
    public function isApplicableForCategory(\XLite\Model\Category $category)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isApplicableForCategory', [$category]);

        return parent::isApplicableForCategory($category);
    }

    /**
     * {@inheritDoc}
     */
    public function isApplicableForProfile(\XLite\Model\Profile $profile)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isApplicableForProfile', [$profile]);

        return parent::isApplicableForProfile($profile);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaDesc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaDesc', []);

        return parent::getMetaDesc();
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaDescType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaDescType', []);

        return parent::getMetaDescType();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaDescType($metaDescType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaDescType', [$metaDescType]);

        return parent::setMetaDescType($metaDescType);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnabled', [$enabled]);

        return parent::setEnabled($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnabled', []);

        return parent::getEnabled();
    }

    /**
     * {@inheritDoc}
     */
    public function setValue($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setValue', [$value]);

        return parent::setValue($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValue', []);

        return parent::getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateRangeBegin($dateRangeBegin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateRangeBegin', [$dateRangeBegin]);

        return parent::setDateRangeBegin($dateRangeBegin);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateRangeBegin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateRangeBegin', []);

        return parent::getDateRangeBegin();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateRangeEnd($dateRangeEnd)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateRangeEnd', [$dateRangeEnd]);

        return parent::setDateRangeEnd($dateRangeEnd);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateRangeEnd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateRangeEnd', []);

        return parent::getDateRangeEnd();
    }

    /**
     * {@inheritDoc}
     */
    public function setShowInSeparateSection($showInSeparateSection)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShowInSeparateSection', [$showInSeparateSection]);

        return parent::setShowInSeparateSection($showInSeparateSection);
    }

    /**
     * {@inheritDoc}
     */
    public function getShowInSeparateSection()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShowInSeparateSection', []);

        return parent::getShowInSeparateSection();
    }

    /**
     * {@inheritDoc}
     */
    public function setSpecificProducts($specificProducts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSpecificProducts', [$specificProducts]);

        return parent::setSpecificProducts($specificProducts);
    }

    /**
     * {@inheritDoc}
     */
    public function getSpecificProducts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSpecificProducts', []);

        return parent::getSpecificProducts();
    }

    /**
     * {@inheritDoc}
     */
    public function addProductClasses(\XLite\Model\ProductClass $productClasses)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addProductClasses', [$productClasses]);

        return parent::addProductClasses($productClasses);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductClasses()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductClasses', []);

        return parent::getProductClasses();
    }

    /**
     * {@inheritDoc}
     */
    public function clearProductClasses()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'clearProductClasses', []);

        return parent::clearProductClasses();
    }

    /**
     * {@inheritDoc}
     */
    public function addMemberships(\XLite\Model\Membership $memberships)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addMemberships', [$memberships]);

        return parent::addMemberships($memberships);
    }

    /**
     * {@inheritDoc}
     */
    public function getMemberships()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMemberships', []);

        return parent::getMemberships();
    }

    /**
     * {@inheritDoc}
     */
    public function clearMemberships()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'clearMemberships', []);

        return parent::clearMemberships();
    }

    /**
     * {@inheritDoc}
     */
    public function addCategories(\XLite\Model\Category $categories)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCategories', [$categories]);

        return parent::addCategories($categories);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategories()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategories', []);

        return parent::getCategories();
    }

    /**
     * {@inheritDoc}
     */
    public function clearCategories()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'clearCategories', []);

        return parent::clearCategories();
    }

    /**
     * {@inheritDoc}
     */
    public function addSaleDiscountProducts(\XLite\Module\CDev\Sale\Model\SaleDiscountProduct $saleDiscountProduct)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addSaleDiscountProducts', [$saleDiscountProduct]);

        return parent::addSaleDiscountProducts($saleDiscountProduct);
    }

    /**
     * {@inheritDoc}
     */
    public function getApplicableProductIds()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApplicableProductIds', []);

        return parent::getApplicableProductIds();
    }

    /**
     * {@inheritDoc}
     */
    public function getSaleDiscountProducts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSaleDiscountProducts', []);

        return parent::getSaleDiscountProducts();
    }

    /**
     * {@inheritDoc}
     */
    public function getCleanURLs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCleanURLs', []);

        return parent::getCleanURLs();
    }

    /**
     * {@inheritDoc}
     */
    public function addCleanURLs(\XLite\Model\CleanURL $cleanURLs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCleanURLs', [$cleanURLs]);

        return parent::addCleanURLs($cleanURLs);
    }

    /**
     * {@inheritDoc}
     */
    public function generateCleanURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'generateCleanURL', []);

        return parent::generateCleanURL();
    }

    /**
     * {@inheritDoc}
     */
    public function setCleanURLs($cleanURLs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCleanURLs', [$cleanURLs]);

        return parent::setCleanURLs($cleanURLs);
    }

    /**
     * {@inheritDoc}
     */
    public function setCleanURL($cleanURL, $force = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCleanURL', [$cleanURL, $force]);

        return parent::setCleanURL($cleanURL, $force);
    }

    /**
     * {@inheritDoc}
     */
    public function getCleanURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCleanURL', []);

        return parent::getCleanURL();
    }

    /**
     * {@inheritDoc}
     */
    public function prepareBeforeSave()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareBeforeSave', []);

        return parent::prepareBeforeSave();
    }

    /**
     * {@inheritDoc}
     */
    public function setEditLanguage($code)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEditLanguage', [$code]);

        return parent::setEditLanguage($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslations', []);

        return parent::getTranslations();
    }

    /**
     * {@inheritDoc}
     */
    public function addTranslations(\XLite\Model\Base\Translation $translation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTranslations', [$translation]);

        return parent::addTranslations($translation);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslation($code = NULL, $allowEmptyResult = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslation', [$code, $allowEmptyResult]);

        return parent::getTranslation($code, $allowEmptyResult);
    }

    /**
     * {@inheritDoc}
     */
    public function getHardTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHardTranslation', [$code]);

        return parent::getHardTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getSoftTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSoftTranslation', [$code]);

        return parent::getSoftTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function hasTranslation($code = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasTranslation', [$code]);

        return parent::hasTranslation($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslationCodes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTranslationCodes', []);

        return parent::getTranslationCodes();
    }

    /**
     * {@inheritDoc}
     */
    public function detach()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'detach', []);

        return parent::detach();
    }

    /**
     * {@inheritDoc}
     */
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', []);

        return parent::cloneEntity();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($method, array $arguments = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', [$method, $arguments]);

        return parent::__call($method, $arguments);
    }

    /**
     * {@inheritDoc}
     */
    public function hasMagicMethod($method)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasMagicMethod', [$method]);

        return parent::hasMagicMethod($method);
    }

    /**
     * {@inheritDoc}
     */
    public function explicitlyLoadTranslations()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'explicitlyLoadTranslations', []);

        return parent::explicitlyLoadTranslations();
    }

    /**
     * {@inheritDoc}
     */
    public function buildDataForREST($withAssociations = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'buildDataForREST', [$withAssociations]);

        return parent::buildDataForREST($withAssociations);
    }

    /**
     * {@inheritDoc}
     */
    public function getModelAssociationsForREST()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModelAssociationsForREST', []);

        return parent::getModelAssociationsForREST();
    }

    /**
     * {@inheritDoc}
     */
    public function _getPreviousState()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '_getPreviousState', []);

        return parent::_getPreviousState();
    }

    /**
     * {@inheritDoc}
     */
    public function map(array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'map', [$data]);

        return parent::map($data);
    }

    /**
     * {@inheritDoc}
     */
    public function __unset($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__unset', [$name]);

        return parent::__unset($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRepository', []);

        return parent::getRepository();
    }

    /**
     * {@inheritDoc}
     */
    public function checkCache()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'checkCache', []);

        return parent::checkCache();
    }

    /**
     * {@inheritDoc}
     */
    public function isPropertyExists($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPropertyExists', [$name]);

        return parent::isPropertyExists($name);
    }

    /**
     * {@inheritDoc}
     */
    public function setterProperty($property, $value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setterProperty', [$property, $value]);

        return parent::setterProperty($property, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getterProperty($property)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getterProperty', [$property]);

        return parent::getterProperty($property);
    }

    /**
     * {@inheritDoc}
     */
    public function isPersistent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPersistent', []);

        return parent::isPersistent();
    }

    /**
     * {@inheritDoc}
     */
    public function isDetached()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDetached', []);

        return parent::isDetached();
    }

    /**
     * {@inheritDoc}
     */
    public function isManaged()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isManaged', []);

        return parent::isManaged();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifierName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifierName', []);

        return parent::getUniqueIdentifierName();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifier', []);

        return parent::getUniqueIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntityName', []);

        return parent::getEntityName();
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldMetadata($property)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldMetadata', [$property]);

        return parent::getFieldMetadata($property);
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'update', []);

        return parent::update();
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'create', []);

        return parent::create();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'delete', []);

        return parent::delete();
    }

    /**
     * {@inheritDoc}
     */
    public function processFiles($field, array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'processFiles', [$field, $data]);

        return parent::processFiles($field, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldsDefinition($class = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldsDefinition', [$class]);

        return parent::getFieldsDefinition($class);
    }

    /**
     * {@inheritDoc}
     */
    public function prepareEntityBeforeCommit($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareEntityBeforeCommit', [$type]);

        return parent::prepareEntityBeforeCommit($type);
    }

    /**
     * {@inheritDoc}
     */
    public function isSerializable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isSerializable', []);

        return parent::isSerializable();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', []);

        return parent::__toString();
    }

}
