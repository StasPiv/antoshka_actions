<?php

class OpsWay_Actions_Model_Action_Image extends Mage_Core_Model_Abstract
{
    const LIST_IMAGE_SIZE = 200;

    const FULL_IMAGE_SIZE = 350;

    private $imageData = array(
        array(
            'key' => 'small_image_path',
            'width' => self::LIST_IMAGE_SIZE,
            'height' => self::LIST_IMAGE_SIZE
        ),
        array(
            'key' => 'full_image_path',
            'width' => self::FULL_IMAGE_SIZE,
            'height' => self::FULL_IMAGE_SIZE
        )
    );

    public function uploadImages(OpsWay_Actions_Model_Action $action)
    {
        foreach ($this->imageData as $imageData) {
            $this->uploadImage($action, $imageData['key'], $imageData['width'], $imageData['height']);
        }
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     * @param $keyName
     * @param $width
     * @param $height
     */
    private function uploadImage(OpsWay_Actions_Model_Action $action, $keyName, $width, $height)
    {
        $name = $_FILES[$keyName]['name'];
        if (isset($name) and (file_exists($_FILES[$keyName]['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader($keyName);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(false);

                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS . OpsWay_Actions_Model_Action::MEDIA_DIR . DS;
                $newFileName = str_replace(
                    basename($name),
                    md5(microtime() . rand(0,9999)) . '_' . $keyName . '.' . $uploader->getFileExtension(),
                    $name
                );

                $uploader->save($path, $newFileName);
                $action->setData($keyName, $newFileName);
            } catch (Exception $e) {

            }
        }
    }
}