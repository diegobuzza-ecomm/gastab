<?php

function mailchimp_subscriber_status($email = '', $merge_fields = '', $tags = '', $list_id = ''){

	$api_key = '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return new WP_Error('invalid_email', 'Invalid email address.');
    }

    // Ensure merge_fields is an associative array
    if (!is_array($merge_fields) || array_values($merge_fields) === $merge_fields) {
        return new WP_Error('invalid_merge_fields', 'Merge fields should be an associative array.');
    }


    // Data
    $data = [
        'email_address' => $email,
        'status_if_new' => 'subscribed',
        'status'        => 'subscribed',
    ];

    if (!empty($merge_fields)){
    	$data['merge_fields'] = $merge_fields;
    }

    if (!empty($tags)){
    	$data['tags'] = $tags;
    }

    $data = json_encode($data);

    // Args
    $args = [
        'method'    => 'PUT',
        'headers'   => [
            'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
            'Content-Type'  => 'application/json'
        ],
        'body'      => $data
    ];

    // Connect
	$memberId = md5(strtolower($email));
    $dataCenter = substr($api_key,strpos($api_key,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . $memberId;

    $response = wp_remote_request($url, $args);


    // Return
    if (is_wp_error($response)) {
        return $response;
    }

    $body = json_decode($response['body'], true);

    if ($response['response']['code'] != 200) {
        return new WP_Error('mailchimp_error', $body['detail'], $body);
    }

    return $body;
}