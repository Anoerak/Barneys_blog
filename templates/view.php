<?php

class View
{

    // Name of the file associated with the view
    private $file;

    // Title of the view (defined in the view file)
    private $title;

    public function __construct($templatePath, $title)
    {
        // Define the view file
        $this->file = "templates/" . $templatePath . ".php";
        $this->title = $title;
    }

    // Generate and display the view
    public function render(array $data)
    {
        // Get the content of the view
        $content = $this->generateRender($this->file, $data);
        // Get the content of the template
        $view = $this->generateRender('templates/layout.php', array('title' => $this->title, 'content' => $content));
        // Display the view
        echo $view;
    }

    // Generate a view file and return the result produced
    private function generateRender($file, $data)
    {
        if (file_exists($file)) {
            // Extract the variables in the array
            extract($data);
            // Start the output buffer
            ob_start();
            // Include the view file
            require $file;
            // Return the content of the buffer
            return ob_get_clean();
        } else {
            throw new Exception("The page '$file' does not exist,<br><br>Details: File '$file' not found", 400);
        }
    }
}