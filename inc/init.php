<?php

class Init
{
    public function __construct()
    {
        // Include required files
        $this->loadDependencies();
        
        // Initialize classes
        $this->initializeClasses();
    }

    /**
     * Load required dependencies.
     */
    private function loadDependencies()
    {
        $files = [
            'cpt.php',
            'custom-fields.php',
            'enqueue.php',
            'shortcodes.php',
        ];

        foreach ($files as $file) {
            $file_path = CP_DIR_PATH . 'inc/' . $file;
            if (file_exists($file_path)) {
                include_once($file_path);
            }
        }
    }

    /**
     * Initialize required classes.
     */
    private function initializeClasses()
    {
        new CPT();
        new Custom_Fields();
        new Enqueue();
        new Shortcodes();
    }
}
