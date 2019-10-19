<?php 

    class Template {
        private $data;
        private $template;
        private $methods;

        private $methodChecks = [
            "if" => [ "re" => "/@if\((.*)\)/m", "rpl" => "<?php if (@) : ?>", "innerval" => true ],
            "elseif" => [ "re" => "/@elseif\((.*)\)/m", "rpl" => "<?php elseif (@): ?>", "innerval" => true ],
            "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>", "innerval" => false ],
            "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>", "innerval" => false ],

            "unless" => [ "re" => "/@unless\((.*)\)/m", "rpl" => "<?php if(!(@)): ?>", "innerval" => true ],
            "endunless" => [ "re" => "/@endunless/m", "rpl" => "<?php endif; ?>", "innerval" => false ],
            
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

        private $layoutChecks = [
            "yield" => [ "re" => "/@yield\((.*)\)/m" ],            
        ];


        public function __construct($filePath) {
            // Load template contents into string variable
            $currentTemplate = file_get_contents($filePath);

            // Add contents from @extends 
            preg_match_all("/@extends\((.*)\)/m", $currentTemplate, $matches, PREG_OFFSET_CAPTURE);
    
            if (sizeof($matches[0]) > 1) throw new Exception('Template can only extend one template');

            if (sizeof($matches[0]) === 1) {
                // render from extended template
                $parentTemplate = self::fromExtendedTemplate($currentTemplate, $matches);
                $this->template = $parentTemplate;                
            } else {
                // Single template, with no parent template
                $this->template = $currentTemplate;
            }

            // Find methods in template
            $this->methods = $this->findMethods();

            // Sort methods by order of position
            $this->sortMethods($this->methods);

            // Replace methods in template with valid php
            $this->template = $this->replaceMethods($this->template, $this->methods, $this->methodChecks);            
        }

        private function fromExtendedTemplate($currentTemplate, $matches) {
            // Extract string to replace
            $extendString = $matches[0][0][0];
            // Remove @extends from current template
            $currentTemplate = str_replace($extendString, '', $currentTemplate);

            $parentPath = APPROOT . '/views/' . str_replace("'", "", str_replace('.', '/', $matches[1][0][0])) . '.tmp.php';
            $parentTemplate = file_get_contents($parentPath);

            // Find any layout methods found in parent template
            $layoutMethods = [];

            foreach($this->layoutChecks as $key => $check) {
                // Each check is a layout method
                // regex
                $re = $check['re'];

                $matches = [];
                preg_match_all($re, $parentTemplate, $matches, PREG_OFFSET_CAPTURE);

                // Add relevent data to layoutMethods
                foreach($matches[0] as $index => $x) {
                    $obj = [
                        "name" => $key,
                        "position" => $x[1],
                        "contents" => isset($matches[1]) ? $matches[1][$index][0] : null,
                        "value" => $x[0],
                    ];
                    $layoutMethods[] = $obj;
                }
            }

            // Sort methods by order of position
            $this->sortMethods($layoutMethods);

            // Replace layout methods with child content section
            foreach($layoutMethods as $key => $parent) {

                if ($parent['name'] === 'yield') {
                    $open = '@section(' . $parent['contents'] . ')';
                    $close = '@endsection';
                    
                    // Extract section with 'contents' name from child template
                    $child = $currentTemplate; 
                    $child = explode($open, $child)[1];
                    $child = explode($close, $child)[0];

                    $parentTemplate = str_replace($parent['value'], $child, $parentTemplate);
                }
            }

            return $parentTemplate;
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
            foreach($this->methodChecks as $key => $check) {
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

        public function render($data = []) {
            $trimmed = preg_replace('~>\s+<~', '><', $this->template);
            echo eval(' ?>' . $trimmed . '<?php ');
        }
    }
