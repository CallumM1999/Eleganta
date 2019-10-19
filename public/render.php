<?php 

    $path = './template.php';
    $template = file_get_contents($path);

    $checks = [
        "if" => [ "re" => "/@if\((.*)\)/m", "rpl" => ["<?php if (", ") : ?>"] ],
        "elseif" => [ "re" => "/@elseif\((.*)\)/m", "rpl" => ["<?php elseif (", "): ?>"] ],
        "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>" ],
        "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>" ],
    ];

    $found = [];

    foreach($checks as $key => $check) {
        $matches = [];
        preg_match_all($check['re'], $template, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as $index => $x) {
            $obj = [
                "name" => $key,
                "position" => $x[1],
                "contents" => isset($matches[1]) ? $matches[1][$index][0] : null,
                "value" => $x[0]
            ];
            array_push($found, $obj);
        }
    }

    usort($found, function($a, $b) {
        return $a['position'] > $b['position'];
    });


    foreach($found as $index => $value) {
        $rpl = $checks[$value['name']]['rpl'];
        $match = $value['value'];
        $replacement;

        if (is_array($rpl)) {
            // Value is sandwiched 
            $replacement = $rpl[0] . $value['contents'] . $rpl[1];
        } else {
            $replacement = $rpl;
        }

        $template = str_replace($match, $replacement, $template);
    };


    echo eval(' ?>' . $template . '<?php ');