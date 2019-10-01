<?php

	class Colors {
		private $foreground_colors = array();
		private $background_colors = array();

		public function __construct() {
			// Set up shell colors
			$this->foreground_colors['black'] = '0;30';
			$this->foreground_colors['dark_gray'] = '1;30';
			$this->foreground_colors['blue'] = '0;34';
			$this->foreground_colors['light_blue'] = '1;34';
			$this->foreground_colors['green'] = '0;32';
			$this->foreground_colors['light_green'] = '1;32';
			$this->foreground_colors['cyan'] = '0;36';
			$this->foreground_colors['light_cyan'] = '1;36';
			$this->foreground_colors['red'] = '0;31';
			$this->foreground_colors['light_red'] = '1;31';
			$this->foreground_colors['purple'] = '0;35';
			$this->foreground_colors['light_purple'] = '1;35';
			$this->foreground_colors['brown'] = '0;33';
			$this->foreground_colors['yellow'] = '1;33';
			$this->foreground_colors['light_gray'] = '0;37';
			$this->foreground_colors['white'] = '1;37';

			$this->background_colors['black'] = '40';
			$this->background_colors['red'] = '41';
			$this->background_colors['green'] = '42';
			$this->background_colors['yellow'] = '43';
			$this->background_colors['blue'] = '44';
			$this->background_colors['magenta'] = '45';
			$this->background_colors['cyan'] = '46';
			$this->background_colors['light_gray'] = '47';
		}

		// Returns colored string
		public function getColoredString($string, $foreground_color = null, $background_color = null) {
			$colored_string = "";

			// Check if given foreground color found
			if (isset($this->foreground_colors[$foreground_color])) {
				$colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
			}
			// Check if given background color found
			if (isset($this->background_colors[$background_color])) {
				$colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
			}

			// Add string and end coloring
			$colored_string .=  $string . "\033[0m";

			return $colored_string;
		}

		// Returns all foreground color names
		public function getForegroundColors() {
			return array_keys($this->foreground_colors);
		}

		// Returns all background color names
		public function getBackgroundColors() {
			return array_keys($this->background_colors);
		}
    }

    function disp_color($var) {
        # blanc et rouge
        $test = "\033[1;37m\033[41m" . $var . "\033[0m";
        return($test);
    }
    function disp_color2($var) {
        # noir et light gray
        $test = "\033[40m\033[0m\033[0;37m" . $var . "\033[0m";
        return($test);
    }
    
    function display_solving_steps($process, $closedList, $openlist_size) {
        $str = $process["parent"];
        $path = array();
        $i = 0;
        $time = count($closedList);
        $path[] = $process["grid"];
        // echo print_grid($process["grid"], $GLOBALS["nbN"]) . "\n";
        while ($str != "start") {
            $path[] = json_decode($closedList[$str], TRUE)["grid"];
            $str = json_decode($closedList[$str], TRUE)["parent"];
            $i++;
        }
        if($i < 50) {
            $timeSleep = 10000000 / (2 * $i);
        } else {
            $timeSleep = 10000000 / $i;
        }
        $pathbis = array_reverse($path);
        foreach ($pathbis as $elem) {
            echo print_grid($elem, $GLOBALS["nbN"]) . "\n";
            usleep((int)$timeSleep);
        }
        echo "Number of moves required : " . $i . "\n";
        echo "complexity in time : " . $time . "\n";   
        echo "complexity in size : " . ($time + $openlist_size) . "\n";
        return 0;
    }
?>