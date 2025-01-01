<?php

namespace Rizk\Kolala\Classes;

use Exception;
use MongoDB\Client;

abstract class MongoDB implements DB{
    protected  $DB,$collection;

    public function __construct(){
        $this->DB = $this->connect();
        $this->collection = $this->DB->selectCollection($this->setCollectionName());
    }

    public abstract function setCollectionName():string;

    public function connect(){
        try {
            $uri = "mongodb://localhost:27017";
            $client = new Client($uri);
            return $client->selectDatabase("Kolala");
        } catch (Exception $e) {
            echo "Error connecting to MongoDB: " . $e->getMessage();
            exit;
        }
    }


    public function insert($document){
        $insertResult = $this->collection->insertOne($document);
        $count = $insertResult->getInsertedCount();
        return $count;
    }
    public function insertMany($document){
        $insertResult = $this->collection->insertOne($document);
        $count = $insertResult->getInsertedCount();
        return $count;
    }

    public function selectOne($filter,$options=[]){
        return $this->collection->findOne($filter,$options);
    }

    public function selectMany($filter,$options=[]){
        $data =[];
        foreach ($this->collection->find($filter,$options) as $item) {
            $data[]=$item;
        }
        return $data;
    }

    public function update($filter,$update,$options=[]){
        $updateResult = $this->collection->updateOne($filter,$update,$options);
        return $updateResult->getMatchedCount();
    }

    public function delete($filter,$options=[]){
        $deleteResult = $this->collection->deleteOne($filter,$options);
        return $deleteResult->getDeletedCount();
    }
}