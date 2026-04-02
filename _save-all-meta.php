<?php
require_once dirname(__FILE__) . '/../../../wp-load.php';
if (!is_user_logged_in() || !current_user_can('edit_posts')) { die('Not authorized.'); }

$products = array(
    array('id' => 2471, 'label' => 'Landscape Dump Body', 'config' => '_fld-dump-config-meta.json', 'tech' => '_fld-dump-tech-meta.json'),
    array('id' => 2472, 'label' => 'Dovetail Landscape Body', 'config' => '_fld-dovetail-config-meta.json', 'tech' => '_fld-dovetail-tech-meta.json'),
);

echo "<h1>Falcon Landscape Bodies — Meta Saver (STAGING)</h1><hr>";

foreach ($products as $p) {
    $post = get_post($p['id']);
    echo "<h2>{$p['label']} (ID: {$p['id']})</h2>";
    if (!$post) { echo "<p style='color:red'>Post not found</p>"; continue; }
    echo "<p>Title: {$post->post_title}</p>";
    $cf = __DIR__ . '/' . $p['config'];
    $tf = __DIR__ . '/' . $p['tech'];
    if (file_exists($cf)) {
        $json = file_get_contents($cf);
        if (json_decode($json)) {
            update_post_meta($p['id'], '_falcon_config_json', wp_slash($json));
            $s = get_post_meta($p['id'], '_falcon_config_json', true);
            echo "<p>✓ config: " . strlen($s) . " chars (valid: " . (json_decode($s)?'YES':'NO') . ")</p>";
        } else { echo "<p style='color:red'>✗ Config JSON invalid</p>"; }
    } else { echo "<p style='color:red'>✗ Config file missing</p>"; }
    if (file_exists($tf)) {
        $json = file_get_contents($tf);
        if (json_decode($json)) {
            update_post_meta($p['id'], '_falcon_tech_overview', wp_slash($json));
            $s = get_post_meta($p['id'], '_falcon_tech_overview', true);
            echo "<p>✓ tech: " . strlen($s) . " chars (valid: " . (json_decode($s)?'YES':'NO') . ")</p>";
        } else { echo "<p style='color:red'>✗ Tech JSON invalid</p>"; }
    } else { echo "<p style='color:red'>✗ Tech file missing</p>"; }
    $gt = get_post_meta($p['id'], 'tab_title_2nd', true);
    if ($gt && $gt !== 'Gallery') { update_post_meta($p['id'], 'tab_title_2nd', 'Gallery'); echo "<p>✓ Fixed gallery tab title</p>"; }
    echo "<p><a href='" . get_permalink($p['id']) . "' target='_blank'>View →</a></p><hr>";
}
echo "<p><strong>DELETE all temp files now.</strong></p>";
