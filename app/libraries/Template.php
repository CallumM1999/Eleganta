<?php 

    class Template {
        private $data;
        private $template;
        private $methods;

        private $checks = [
            "if" => [ "re" => "/@if\((.*)\)/m", "rpl" => ["<?php if (", ") : ?>"] ],
            "elseif" => [ "re" => "/@elseif\((.*)\)/m", "rpl" => ["<?php elseif (", "): ?>"] ],
            "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>" ],
            "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>" ],

            "unless" => [ "re" => "/@unless\((.*)\)/m", "rpl" => ["<?php if(!(", ")): ?>"] ],
            "endunless" => [ "re" => "/@endunless/m", "rpl" => "<?php endif; ?>" ],
            
            /*
            Variables not included yet

            "isset" => [ "re" => "/@isset\((.*)\)/m", "rpl" => ["<?php if(isset(", ")): ?>"] ],
            "endisset" => [ "re" => "/@endisset/m", "rpl" => "<?php endif; ?>" ],

            "empty" => [ "re" => "/@empty\((.*)\)/m", "rpl" => ["<?php if(!isset(", ")): ?>"] ],
            "endempty" => [ "re" => "/@endempty/m", "rpl" => "<?php endif; ?>" ],
            */

            "switch" => [ "re" => "/@switch\((.*)\)/m", "rpl" => ["<?php switch(", "): ?>"] ],
            "case" => [ "re" => "/@case\((.*)\)/m", "rpl" => ["<?php case ", " : ?>"] ],
            "break" => [ "re" => "/@break/m", "rpl" => "<?php break; ?>" ],
            "default" => [ "re" => "/@default/m", "rpl" => "<?php default: ?>" ],
            "endswitch" => [ "re" => "/@endswitch/m", "rpl" => "<?php endswitch; ?>" ],

            "foreach" => [ "re" => "/@foreach\((.*)\)/m", "rpl" => ["<?php foreach(", "): ?>"] ],
            "endforeach" => [ "re" => "/@endforeach/m", "rpl" => "<?php endforeach; ?>" ]
        ];

        /*

        @unless
        @endunless

        @isset

        @empty

        @switch
        @case
        @break
        @default
        @endswitch

        @foreach
        @endforeach



        */

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
                $replacement = (is_array($rpl)) ? $rpl[0] . $value['contents'] . $rpl[1] : $rpl;     
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
            $trimmed = preg_replace('~>\s+<~', '><', $this->template);
            echo eval(' ?>' . $trimmed . '<?php ');
        }
    }
