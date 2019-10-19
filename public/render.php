<?php 

    class Render {
        private $data;
        private $template;
        private $methods;

        private $checks = [
            "if" => [ "re" => "/@if\((.*)\)/m", "rpl" => ["<?php if (", ") : ?>"] ],
            "elseif" => [ "re" => "/@elseif\((.*)\)/m", "rpl" => ["<?php elseif (", "): ?>"] ],
            "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>" ],
            "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>" ],
        ];

        public function __construct($filePath, $data = []) {
            // Data used in template
            $this->data = $data;

            // Load template contents into string variable
            $this->template = file_get_contents($filePath);

            // Find methods in template
            $this->methods = $this->findMethods();

            // Sort methods by order of position
            $this->sortMethods($this->methods);

            // Replace methods in template with valid php
            $this->template = $this->replaceMethods($this->template, $this->methods, $this->checks);            
        }

        public function replaceMethods($template, $methods, $checks) {
            $newTemplate = $template;

            foreach($methods as $index => $value) {
                $rpl = $checks[$value['name']]['rpl'];
                $match = $value['value'];
                $replacement;
        
                if (is_array($rpl)) {
                    // Value is sandwiched 
                    $replacement = $rpl[0] . $value['contents'] . $rpl[1];
                } else {
                    $replacement = $rpl;
                }
        
                
                $newTemplate = str_replace($match, $replacement, $newTemplate);
            };

            return $newTemplate;
        }

        private function sortMethods($methods) {
            usort($methods, function($a, $b) {
                return $a['position'] > $b['position'];
            });
        }

        private function findMethods() {
            $methods = [];
            foreach($this->checks as $key => $check) {
                $matches = [];
                preg_match_all($check['re'], $this->template, $matches, PREG_OFFSET_CAPTURE);
        
                foreach($matches[0] as $index => $x) {
                    $obj = [
                        "name" => $key,
                        "position" => $x[1],
                        "contents" => isset($matches[1]) ? $matches[1][$index][0] : null,
                        "value" => $x[0]
                    ];
                    $methods[] = $obj;
                }
            }
            return $methods;
        }

        public function render() {
            echo eval(' ?>' . $this->template . '<?php ');
        }
    }

    $path = './template.php';
    $template = new Render($path, []);    
    
    $template->render();