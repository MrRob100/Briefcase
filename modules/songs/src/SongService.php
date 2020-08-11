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
            ->fields('s', ['name'])
            ->orderBy('time_uploaded', 'DESC')
            ->range(0, 2);

        try {
            $songs_list = $query->execute()->fetchAll();
        } catch (\Exception $e) {

            \Drupal::logger('songs')->alert('Failed to query database: '. $e->getMessage());
            \Drupal::messenger()->addError('Failed to query database: '. $e->getMessage());

            return;
        }

        return $songs_list;
    }

    public function update($id) {
        //not yet
    }

    public function delete($id) {
        //
    }
}