<?php 


class imaging
    {

        // Variables
        private $img_input;
        private $img_output;
        public  $img_src;
        private $format;
        private $quality = 70;
        private $x_input;
        private $y_input;
        private $x_output;
        private $y_output;
        private $resize;

        // Set image
        public  function set_img($img)
        {           

          if(!file_exists($img)){
              $ext = substr($img, -3);
              $target = "img.".$ext;
              $this->loadImage($img,$target);
              $img = $target ; 
          }

            // Find format
            $ext = strtoupper(pathinfo($img, PATHINFO_EXTENSION));

            // JPEG image
            if(is_file($img) && ($ext == "JPG" OR $ext == "JPEG"))
            {

                $this->format = $ext;
                $this->img_input = ImageCreateFromJPEG($img);
                $this->img_src = $img;
               

            }

            // PNG image
            elseif(is_file($img) && $ext == "PNG")
            {

                $this->format = $ext;
                $this->img_input = ImageCreateFromPNG($img);
                $this->img_src = $img;

            }

            // GIF image
            elseif(is_file($img) && $ext == "GIF")
            {

                $this->format = $ext;
                $this->img_input = ImageCreateFromGIF($img);
                $this->img_src = $img;

            }

            // Get dimensions
            $this->x_input = imagesx($this->img_input);
            $this->y_input = imagesy($this->img_input);

        }

        // Set maximum image size (pixels)
        public  function set_size($size = 650)
        {

            // Resize
            if($this->x_input > $size && $this->y_input > $size)
            {

                // Wide
                if($this->x_input >= $this->y_input)
                {

                    $this->x_output = $size;
                    $this->y_output = ($this->x_output / $this->x_input) * $this->y_input;

                }

                // Tall
                else
                {

                    $this->y_output = $size;
                    $this->x_output = ($this->y_output / $this->y_input) * $this->x_input;

                }

                // Ready
                $this->resize = TRUE;

            }

            // Don't resize
            else { $this->resize = FALSE; }

        }


        // Load image From Any Server
        public  function loadImage($url,$target)
        {
            $ch = curl_init($url);
            $fp = fopen($target, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        }


        // Set image quality (JPEG only)
        public  function set_quality($quality)
        {

            if(is_int($quality))
            {

                $this->quality = $quality;

            }

        }

        // Save image
        public  function save_img($path)
        {

            // Resize
            if($this->resize)
            {

                $this->img_output = ImageCreateTrueColor($this->x_output, $this->y_output);
                ImageCopyResampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);

            }

            // Save JPEG
            if($this->format == "JPG" OR $this->format == "JPEG")
            {

                if($this->resize) { imageJPEG($this->img_output, $path, $this->quality); }
                else { copy($this->img_src, $path); }

            }

            // Save PNG
            elseif($this->format == "PNG")
            {

                if($this->resize) { imagePNG($this->img_output, $path); }
                else { copy($this->img_src, $path); }

            }

            // Save GIF
            elseif($this->format == "GIF")
            {

                if($this->resize) { imageGIF($this->img_output, $path); }
                else { copy($this->img_src, $path); }

            }

        }


         // Preview image
        public  function preview_img()
        {

            // Resize
            if($this->resize)
            {

                $this->img_output = ImageCreateTrueColor($this->x_output, $this->y_output);
                ImageCopyResampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);

            }

           
            if($this->format == "JPG" OR $this->format == "JPEG")
            { // Save JPEG
                 header('Content-Type: image/jpeg');
                if($this->resize) { 
                        imageJPEG($this->img_output, null, $this->quality); }
                else {   readfile($this->img_src); }

            }elseif($this->format == "PNG")
            {// Save PNG
                 header('Content-Type: image/png');
                if($this->resize) { imagePNG($this->img_output); }
                else {  readfile($this->img_src); }

            }elseif($this->format == "GIF")
            {// Save GIF
                 header('Content-Type: image/gif');
                if($this->resize) { imageGIF($this->img_output); }
                else {  readfile($this->img_src); }

            }

        }

        // Get width
        public  function get_width()
        {

            return $this->x_input;

        }

        // Get height
        public  function get_height()
        {

            return $this->y_input;

        }

        // Clear image cache
        public  function clear_cache()
        {

            @ImageDestroy($this->img_input);
            @ImageDestroy($this->img_output);

        }

    }

    ?>