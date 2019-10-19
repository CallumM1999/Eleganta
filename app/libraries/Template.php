<?php 

    class Template {
        private $data;
        private $template;
        private $methods;

        private $checks = [
            "if" => [ "re" => "/@if\((.*)\)/m", "rpl" => "<?php if (@) : ?>", "innerval" => true ],
            "elseif" => [ "re" => "/@elseif\((.*)\)/m", "rpl" => "<?php elseif (@): ?>", "innerval" => true ],
            "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>", "innerval" => false ],
            "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>", "innerval" => false ],

            "unless" => [ "re" => "/@unless\((.*)\)/m", "rpl" => "<?php if(!(@)): ?>", "innerval" => true ],
            "endunless" => [ "re" => "/@endunless/m", "rpl" => "<?php endif; ?>", "innerval" => false ],
            
            /*
            Variables not included yet

            "isset" => [ "re" => "/@isset\((.*)\)/m", "rpl" => ["<?php if(isset(", ")): ?>"] ],
            "endisset" => [ "re" => "/@endisset/m", "rpl" => "<?php endif; ?>" ],

            "empty" => [ "re" => "/@empty\((.*)\)/m", "rpl" => ["<?php if(!isset(", ")): ?>"] ],
            "endempty" => [ "re" => "/@endempty/m", "rpl" => "<?php endif; ?>" ],
            */

            "switch" => [ "re" => "/@switch\((.*)\)/m", "rpl" => "<?php switch(@): ?>", "innerval" => true ],
            "case" => [ "re" => "/@case\((.*)\)/m", "rpl" => "<?php case @ : ?>", "innerval" => true ],
            "default" => [ "re" => "/@default/m", "rpl" => "<?php default: ?>", "innerval" => false ],
            "endswitch" => [ "re" => "/@endswitch/m", "rpl" => "<?php endswitch; ?>", "innerval" => false ],

            "foreach" => [ "re" => "/@foreach\((.*)\)/m", "rpl" => "<?php foreach(@): ?>", "innerval" => true ],
            "endforeach" => [ "re" => "/@endforeach/m", "rpl" => "<?php endforeach; ?>", "innerval" => false ],

            "for" => [ "re" => "/@for\((.*)\)/m", "rpl" => "<?php for(@): ?>", "innerval" => true ],
            "endfor" => [ "re" => "/@endfor/m", "rpl" => "<?php endfor; ?>", "innerval" => false ],


            "break" => [ "re" => "/@break/m", "rpl" => "<?php break; ?>", "innerval" => false ],

            "var" => [ "re" => "/\{\{(.*?)\}\}/m", "rpl" => "<?= isset($@) ? $@ : \$data['@'] ?>", "innerval" => true ],


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

                $replacement = ($value['innerval']) ? str_replace('@', trim($value['contents']), $rpl) : $rpl;
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
                        "value" => $x[0],
                        "innerval" => $check['innerval']
                    ];
                    $methods[] = $obj;
                }
            }
            return $methods;
        }

        public function render() {
            $data = [
                "name" => "callum",
                "title" => "Page Title"
            ];

            $trimmed = preg_replace('~>\s+<~', '><', $this->template);
            echo eval(' ?>' . $trimmed . '<?php ');
        }
    }
