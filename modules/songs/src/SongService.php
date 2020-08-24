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
    public function read($page) {

        $connection = \Drupal::database();

        $per_page = 3;

        $lower = ($page - 1) * $per_page;


        $query = $connection->select('songs', 's')
            ->fields('s', ['id', 'name'])
            ->orderBy('time_uploaded', 'DESC')
            ->range($lower, $per_page);
            // ->range(0, 3); //1
            // ->range(3, 3); //2
            // ->range(6, 3); //3

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

            $message = 'Failed to query database: '. $e->getMessage();

            \Drupal::logger('songs')->alert($message);
            \Drupal::messenger()->addError($message);

            return $message;

        }

        //delete file
        try {
            unlink('public://songs/'.$name);
        
        } catch (\Exception $e) {

            $message = 'Failed to delete file: '.$name.' '.$e->getMessage();

            \Drupal::logger('songs')->alert($message);
            \Drupal::messenger()->addError($message);

            return $message;

        }


        //delete db record
        $query = $connection->delete('songs')
         ->condition('id', $id);

        try {
            $response = $query->execute();

        } catch (\Exception $e) {

            $message = 'Failed to delete record '.$id.'in database: '. $e->getMessage();

            \Drupal::logger('songs')->alert($message);
            \Drupal::messenger()->addError($message);

            return $message;

        }

        return 'Song deleted successfully';

    }

}