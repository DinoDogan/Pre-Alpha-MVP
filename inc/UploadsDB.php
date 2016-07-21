<?php

    class UploadsDB
    {
        // used for file locking
        private $db_handle;
        private $counter_handle;

        public $root = __DIR__ . "/../db/uploads/";

        // $root is prepended to these vars on construct
        private $db_path = "db.xml";
        private $counter_path = "counter.db";

        public $db = null;
        public $counter = null;

        public function increment_counter()
        {
            return $this->counter++;
        }

        public function add_file($name = "newfile.pdf", $email = "", $message = "")
        {
            $new_file_entry = $this->db->addChild('file');
            $new_file_entry->addChild('name', htmlspecialchars($name));
            $new_file_entry->addChild('id', $this->increment_counter());
            $new_file_entry->addChild('email', $email);
            $new_file_entry->addChild('message', $message);

            return $new_file_entry;
        }

        public function entry_id($index_id)
        {
            return $this->load_entry($index_id)->id;
        }

        public function get_file_path($index_id) {
            return $this->root . $this->entry_id($index_id) . ".pdf";
        }

        public function remove_file($index_id)
        {
            // unset($upload_entry[0]);
            return unlink($this->get_file_path($index_id));
        }

        public function read_file($index_id)
        {
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename=' . $this->load_entry($index_id)->name);
            readfile($this->root . $this->entry_id($index_id) . ".pdf");
        }

        /**
         * Index IDs vs. entry IDs
         *
         * Internally, our IDs are just a pointer
         * to an entry in the XML (from 0 to infinity).
         *
         * Then, each XML has an actual id property which
         * points to a file. Keep this in mind.
         *
         * Index IDs (indices) change as entries are deleted.
         * Actual IDs don't.
         */
        public function load_entry($index_id)
        {
            if (is_numeric($index_id))
                return $this->db->file[(int)$index_id];
            else
                return false;
        }

        private function open_filesystem()
        {
            //
            // create files
            //

            if (!is_dir($this->root))
                mkdir($this->root);

            if (!is_file($this->db_path))
                file_put_contents($this->db_path, '<?xml version="1.0"?><uploads></uploads>');

            if (!is_file($this->counter_path))
                file_put_contents($this->counter_path, "0");

            //
            // lock files
            //
            $this->db_handle = fopen($this->db_path, "r+");
            flock($this->db_handle, LOCK_EX);

            $this->counter_handle = fopen($this->counter_path, "r+");
            flock($this->counter_handle, LOCK_EX);

            $this->db = simplexml_load_file($this->db_path);
            $this->counter = file_get_contents($this->counter_path);
        }

        public function save()
        {
            return file_put_contents($this->counter_path, $this->counter) !== false
            && $this->db->asXML($this->db_path) !== false;
        }

        private function close_filesystem()
        {
            //
            // unlock filesystem
            //
            fclose($this->db_handle);
            fclose($this->counter_handle);
        }

        public function __construct()
        {
            $this->db_path = $this->root . $this->db_path;
            $this->counter_path = $this->root . $this->counter_path;

            $this->open_filesystem();
        }

        public function __destruct()
        {
            $this->close_filesystem();
        }
    }

?>