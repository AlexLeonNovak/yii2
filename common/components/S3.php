<?php

namespace common\components;

use Yii;
//use yii\base\Component;
use Aws\S3\S3Client;
//use Aws\Credentials\Credentials;

/**
 * Description of S3
 *
 * @author Alex Novak <alexleonnovak@gmail.com>
 */
class S3
{
    private $bucket;
    
    //Access Control Level - Доступы
    const ACL_PUBLIC = 'public-read';
    const ACL_PUBLIC_RW = 'public-read-write';
    const ACL_PRIVATE = 'private';
    
    protected $s3;
    
    public function __construct() {
        $params = Yii::$app->params['S3'];
        $this->bucket = $params['bucket'];
        $this->s3 = S3Client::factory([
            'endpoint' => $params['api_url'],
            'region' => 'default',
            'version' => 'latest',
            'credentials' => [
                'key' => $params['key_access'],
                'secret' => $params['key_secret']
            ]
        ]);
    }
    
    /**
     * 
     * @param type $name
     * @param object $file
     */
    public function upload($name, $file, $acl = self::ACL_PRIVATE) {
        
        $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => "{$name}",
            'Body' => fopen($file, 'rb'),
            'ACL' => $acl
        ]);
        if (file_exists($name)) {unlink($name);}
        if (file_exists($file)) {unlink($file);}
    }
    
    /**
     * Возвращает урл адрес объекта
     * в переменную $time нужно указать время доступа к объекту
     * например '+1 minute', '+10 seconds'
     * @param string $name имя объекта
     * @param string $time Время доступа
     * @return string url
     */
    public function getUrl($name, $time = ''){
        if ($time) {
            $command = $this->s3->getCommand('GetObject', ['Bucket' => $this->bucket, 'Key' => $name]);
            return $this->s3->createPresignedRequest($command, $time)->getUri()->__toString();
        } else {
            return $this->s3->getObjectUrl($this->bucket, $name);
        }
    }
    
    public function delete($name) {
        $this->s3->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $name
        ]);
    }
    
    public function exist($name) {
        return $this->s3->doesObjectExist($this->bucket, $name);
    }
}
