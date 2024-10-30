<?php

// This file contains all the footer functions

function createPageViewTags() {
    // this function creates all page view tags
    // NEED TO CHECK PAGE IS NOT DRAFT - add this in
    // declare some global variables we'll need

   
    global $coremetricsBlogID;
    global $cm_pageType;
    global $cm_attributeCustom;
    global $cm_languageAttribute;
    global $cm_countryAttribute;
    global $post;
    global $cm_pageIDCustom;
    
    $cm_attributeCustom = get_option('cm_attribute_override');
    $cm_pageIDCustom = get_option('cm_custom_pageID');
    $cm_postTags = '';
    $cm_firstTag = '';


    // set up the tags
    $posttags = get_the_tags();
    if ($posttags) {
        $tagi = 0;
        foreach($posttags as $tag) {
            if ($tagi == 0) 
                $cm_firstTag = $tag->name;
            
            $cm_postTags = $tag->name . ',';
            $tagi++;
        }
    }
            
    // check if a tag is set
   $cm_singleTag = single_tag_title('',false);


   // set up the page author

   $user_info = get_userdata($post->post_author);

   $cm_pageAuthor = $user_info->user_login;
    
    /* here are the standard tags for the page, in order - these combine into $cm_tagString
    *
    * $cm_pageTitleTag - identifies page, i.e. [page title - blog ID], [blog ID home], [Archive [month][year] - blog ID], [category page: [category] - [blog ID]]
    * $cm_pageTypeTag - identifies page type, i.e. [blog ID - post], [blog ID - page], [blog ID - archive] etc
    *
    * Now the default attributes - these combine into $cm_attributeString
    *
    * $cm_languageAttribute - language of the blog - needs to be set in general setings
    * $cm_countryAttribute - country - needs to be set in general settings
    * $cm_pageIdentifier - page identifier, usually [tag1]-blogpost or similar - very context-dependent
    * $cm_postTags - all post tags, comma separated
    * $cm_postAuthor - post author(s)
    * $cm_publishMonth - month published
    * $cm_publishYear - year published
    *
    */
    
    
    // first up, what kind of page are we on?
    
    if (is_home()) {
        $cm_pageType = 'Home';
        $cm_pageTitleTag = $coremetricsBlogID . ' Home';
        $cm_pageTypeTag = $coremetricsBlogID;
    }
    
    else if (is_single()) {
        $cm_pageType = $cm_firstTag . '-BlogPost';
        $cm_pageTitleTag = wp_title('',false) . ' - ' . $coremetricsBlogID;
        $cm_pageTypeTag = $coremetricsBlogID . ' - Post';
    }
    
    else if (is_page()) {
        $cm_pageType = 'Page';
        $cm_pageTitleTag = wp_title('',false) . ' - ' . $coremetricsBlogID;
        $cm_pageTypeTag = $coremetricsBlogID . ' - Page';
    }
    
    else if (is_category()) {
        $cm_pageType = str_replace (" ", "", single_cat_title('',false)) . '-CategoryList';
        $cm_pageTitleTag = 'Category list: ' . single_cat_title('',false) . ' - ' . $coremetricsBlogID;
        $cm_pageTypeTag = $coremetricsBlogID . ' Category listing';
    }

    // author
    elseif (is_author()) {
        $cm_pageType = $cm_pageAuthor . '-AuthorPage';
        $cm_pageTitleTag = 'Author listing: ' . $cm_pageAuthor . ' - ' . $coremetricsBlogID;
        $cm_pageTypeTag = $coremetricsBlogID . ' - author page';
    }

    // search
    elseif (is_search()) {
        $cm_pageType = 'SearchPage';
        $cm_pageTitleTag = 'Search for: ' . get_search_query() . ' - ' . $coremetricsBlogID;
        $cm_pageTypeTag = $coremetricsBlogID . ' - search results';
    }

    // any generic admin page
    elseif (is_admin()) {
    $cm_pageType = 'AdminPage';
    $cm_pageTitleTag = $coremetricsBlogID . ' Admin';
    $cm_pageTypeTag = $coremetricsBlogID . ' - admin page';
    }

    // login page
    elseif (is_admin()) {
    $cm_pageType = 'AdminPage';
    $cm_pageTitleTag = $coremetricsBlogID . ' Admin';
    $cm_pageTypeTag = $coremetricsBlogID . ' - admin page';
    }

    
    else if (is_archive() && function_exists(get_the_date)) {
        
        if (!isset($cm_singleTag)) {
            if (is_day()) {
                $cm_pageType = get_the_date() . '-BlogArchive';
                $cm_pageTitleTag = 'Daily archive: ' . get_the_date() . ' - ' . $coremetricsBlogID;
                $cm_pageTypeTag = $coremetricsBlogID . ' - daily archive';
            }
            
            elseif (is_month()) {
                $cm_pageType = get_the_date('FY') . '-BlogArchive';
                $cm_pageTitleTag = 'Monthly archive: ' . get_the_date('F Y') . ' - ' . $coremetricsBlogID;
                $cm_pageTypeTag = $coremetricsBlogID . ' - monthly archive';
            }
            
            elseif (is_year()) {
                $cm_pageType = get_the_date('Y') . '-BlogArchive';
                $cm_pageTitleTag = 'Yearly archive: ' . get_the_date('Y') . ' - ' . $coremetricsBlogID;
                $cm_pageTypeTag = $coremetricsBlogID . ' - yearly archive';
            }
     }
        
        else {
            $cm_pageType = $cm_singleTag . '-TagPage';
            $cm_pageTitleTag = 'Tag archive: ' . $cm_singleTag . ' - ' . $coremetricsBlogID;
            $cm_pageTypeTag = $coremetricsBlogID . ' - archive';
        }
        
    }

    // fallback statement
    else {
        if (basename($_SERVER['PHP_SELF']) == 'wp-login.php') {
        $cm_pageType = 'Login-Register';
        $cm_pageTitleTag = $coremetricsBlogID . ' login, register or password reminder page';
        $cm_pageTypeTag = $coremetricsBlogID . ' login, register or password reminder';
        }
        else {
        $cm_pageType = 'Unknown';
        $cm_pageTitleTag = $coremetricsBlogID . ' unknown page type: ' . basename($_SERVER['PHP_SELF']);
        $cm_pageTypeTag = $coremetricsBlogID;
        }
    }
    
    // Are we on standard or custom attribute strings?
    // Awaiting development...
    //$cm_attributeCustom == 'standard'
    if ($cm_attributeCustom == 'default') {
       // $cm_languageAttribute - language of the blog - set as global
       // $cm_countryAttribute - country of blog - set as global
        $cm_postAuthor = get_the_author(); // replaced the_author with get_the_author
        if (function_exists('get_the_date')) {$cm_publishMonth = get_the_date('F');
        $cm_publishYear = get_the_date('Y');}
        else
        {$cm_publishMonth = the_date('F', '', '', false);
        $cm_publishMonth = the_date('Y', '', '', false);
        }
        
        $cm_attributeString = '\'' . $cm_languageAttribute . '-_-' . $cm_countryAttribute . '-_-' . $cm_pageType . '-_-' . $cm_postTags . '-_-' . $cm_postAuthor . '-_-' . $cm_publishMonth . '-_-' . $cm_publishYear . '\'';
    }
    
    else {
        
        // define a function to get the relevant page details depending on value passed
        
        function definePageDetail ($attribute_value_passed) {
            global $post;
            global $cm_pageIDCustom;
              // check if a tag is set
            $cm_singleTag = single_tag_title('',false);
            switch ($attribute_value_passed) {
                
                case '' : return '';
                    break;
                case 'title' : if(is_home()){ return 'Home';} else if(is_category()) { return str_replace (" ", "", single_cat_title('',false)) . ' category list';} else if (is_month()) {return 'Archive page:' . get_the_date('F Y');} else if (is_year()) {return 'Archive page:' . get_the_date('Y');} else if (isset($cm_singleTag)) {return 'Tag archive: ' . $cm_singleTag;} else {return $post->post_title;};
                    break;
                case 'time' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return date('H:i',strtotime($post->post_date));};
                    break;
                case 'date' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return date('Y-m-d',strtotime($post->post_date));};
                    break;
                case 'permalink' : if (is_home() || is_category() || is_archive() || is_search()) {return $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];} else {return get_permalink($post->ID);};
                    break;
                case 'category' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {$category_list = ''; foreach (get_the_category($post->ID) as $category) {$category_list .= $category->cat_name . ',';} return $category_list;};
                    break;
                case 'author' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {$curauth = get_userdata(($post->post_author)); return $curauth->display_name;};
                    break;
                case 'ID' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->ID;};
                    break;
                case 'SearchQuery' : return get_search_query();
                    break;
                case 'bloginfoName' : return get_bloginfo('name');
                    break;
                case 'bloginfoChar' : return get_bloginfo('charset');
                    break;
                case 'bloginfoVers' : return get_bloginfo('version');
                    break;
                case 'bloginfoHTML' : return get_bloginfo('html_type');
                    break;
                case 'isSticky' : if (is_sticky()) {return 'true';} else {return 'false';};
                    break;
                case 'isPage' : if (is_page()) {return 'true';} else {return 'false';};
                    break;
                case 'getcustomkeys' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else if (!function_exists(get_custom_post_keys)) {return 'This attribute not available in this WP version';} else {return (implode(',',get_post_custom_keys($post->ID)));};
                    break;
                case 'authorNum' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->post_author;};
                    break;

                case 'postStatus' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->post_status;};
                    break;
                case 'commentStatus' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->comment_status;};
                    break;
                case 'modifiedDate' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->post_modified;};
                    break;
                case 'commentCount' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->comment_count;};
                    break;
                case 'menuOrder' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->menu_order;};
                    break;
                case 'postType' : if (is_home() || is_category() || is_archive() || is_search()) {return 'Listing page or search';} else {return $post->post_type;};
                    break;


            }
        }
        
        
        // get the tactical attribute options
        $cm_tacticalFinalAtts = get_option('cm_tactical_attributes');
        
        // define a function to echo the tactical attributes
        function echoTacticals () {
            $cm_tacticalFinalAtts = get_option('cm_tactical_attributes');
            $output = '';
            // now process the array into individual components
            foreach ($cm_tacticalFinalAtts as $cm_tacticalAtts_key => $cm_tacticalAtts_array) {
                foreach ($cm_tacticalAtts_array as $attsKey => $attsValue) {
                    switch ($attsKey) {
                    case 'prefix' : $output .= $attsValue;
                        break;
                    case 'value' : $output .= definePageDetail($attsValue); // for now, put in the value... we need to create a function to handle this!
                        break;
                    case 'suffix' : $output .= $attsValue;
                        break;
                    }
            }

                $output .= '-_-';

        }
        return $output;
        }
        
        
        $cm_attributeString = '\'' . echoTacticals();
        
        // get the strategic options
        $cm_strategicFinalAtts = get_option('cm_strategic_attributes');
        
                // define a function to echo the strategic attributes
        function echoStrategic () {
            $cm_strategicFinalAtts = get_option('cm_strategic_attributes');
            $countStrategic = count($cm_strategicFinalAtts);
            $i = 0;
            $output = '';
            // now process the array into individual components
            foreach ($cm_strategicFinalAtts as $cm_strategicAtts_key => $cm_strategicAtts_array) {
                foreach ($cm_strategicAtts_array as $attsKey => $attsValue) {
                    switch ($attsKey) {
                    case 'prefix' : $output .= $attsValue;
                        break;
                    case 'value' : $output .= definePageDetail($attsValue); 
                        break;
                    case 'suffix' : $output .= $attsValue;
                        break;
                    }
            }
            if ($i <= $countStrategic-2) {
                $output .= '-_-';
            }
            $i++;
        }
        return $output;
        }
        
        
        $cm_attributeString .= echoStrategic() . '\'';
        
        
    }
    
    // padding null values
    
    $cm_stringPadding = ',null,null,';
    
    // create title tag string
    $cm_tagString = '"' . $cm_pageTitleTag . '","' . str_replace(" ", "", $cm_pageTypeTag) . '"';
    
    // final echoes
    
            global $post;


    // 1.1 need to check if page ID is being overwritten:



    if ($cm_pageIDCustom == '') {

    $cm_finalCode = '
                    <script type="text/javascript">
                       cmCreatePageviewTag(' . $cm_tagString . $cm_stringPadding . $cm_attributeString . ');
                    </script>
                    ';
    
    }
    
    else
        
    {
        $cm_finalCode = '
                    <script type="text/javascript">
                        var customPage='.stripslashes($cm_pageIDCustom).';
                        cmCreatePageviewTag(customPage, "' . str_replace(" ", "", $cm_pageTypeTag) . '"' . $cm_stringPadding . $cm_attributeString . ');

                    </script>

                    ';
    }

    // carry out the check - are we tracking drafts? Is this page a draft?
    
    global $post;
    $cm_draftTracking = get_option('cm_track_drafts');
    $cm_pageIsDraft = $post->post_status;
    
    if($cm_draftTracking == 'false' && $cm_pageIsDraft == 'draft') {
        echo '<!-- no Coremetrics tracking - draft page -->';
    }
    else {
    echo $cm_finalCode;
    }
    
}



?>