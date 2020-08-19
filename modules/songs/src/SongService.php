<?php

namespace Drupal\Songs;

class SongService {

    public function test() {
        return 'lala';
    }

    /**
     * writes song record to db and 
     */
    public function write() {
        //
    }

    /**
     * Returns all songs (paginated)
     */
    public function read() {

        $connection = \Drupal::database();

        $query = $connection->select('songs', 's')
            ->fields('s', ['id', 'name'])
            ->orderBy('time_uploaded', 'DESC')
            ->range(0, 2);

        try {
            $songs_list = $query->execute()->fetchAllAssoc('id');
        } catch (\Exception $e) {

            \Drupal::logger('songs')->alert('Failed to query database: '. $e->getMessage());
            \Drupal::messenger()->addError('Failed to query database: '. $e->getMessage());

            return [];
        }

        return $songs_list;
    }

    public function update($id) {
        //not yet
    }

    public function delete($id) {

        $connection = \Drupal::database();

        //get name (to delete file)
        $get_name = $connection->select('songs', 's')
            ->fields('s', ['name'])
            ->condition('id', $id);


        $name = $get_name->execute()->fetchAll()[0]->name;

        try {
            $name = $get_name->execute()->fetchAll()[0]->name;
        
        } catch (\Exception $e) {

            \Drupal::logger('songs')->alert('Failed to query database: '. $e->getMessage());
            \Drupal::messenger()->addError('Failed to query database: '. $e->getMessage());

        }

        //delete file
        try {
            unlink('public://songs/'.$name);
        
        } catch (\Exception $e) {

            \Drupal::logger('songs')->alert('Failed to delete file: '.$name.' '.$e->getMessage());
            \Drupal::messenger()->addError('Failed to delete file: '.$name.' '.$e->getMessage());

        }


        //delete db record
        $query = $connection->delete('songs')
         ->condition('id', $id);

        try {
            $response = $query->execute();
            \Drupal::logger('songs')->alert(json_encode($response));

        } catch (\Exception $e) {

            \Drupal::logger('songs')->alert('Failed to delete record '.$id.'in database: '. $e->getMessage());
            \Drupal::messenger()->addError('Failed to delete record '.$id.'in database: '. $e->getMessage());

        }

        return;

    }

}