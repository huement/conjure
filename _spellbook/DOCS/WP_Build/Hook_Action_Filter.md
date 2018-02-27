## Hook | Action | Filter
### Get In, Get Out, Get on with it.
===============================================
    
      
>  "I put a spell on you, and now you’re mine."
>     — Winifred Sanderson
    
      
A **HOOK** is a place in WordPress’s code that can get **functions** added to it. 

When you create a hook, you give yourself and other developers the opportunity to add in additional functionality at that location.

**HOOKED FUNCTIONS** are custom PHP functions that we can **HOOK INTO** WordPress, at the locations specified by its hooks.
    
      
### Hooks. Tell me more.

Two types of hooked functions exist: **ACTIONS** and **FILTERS**. 

**FILTERS** modify existing output, while **ACTIONS** can do any type of custom functionality.

**FILTERS** are passed code or markup by their filter hooks; they modify what they are passed, and **must return the result** back for WordPress to use in its regular processing.

**ACTIONS**, by contrast, do not need to return a value, and often are not passed specific parameters by their action hooks.
    
      
#### Im all hooked up?

Hooks — both action hooks and filter hooks - are essentially a way for WORDPRESS CORE to allow in 3rd party code. 

This outside code can either be from your themes functions.php file, or from a Wordpress plugin that has been installed. 

Each hook is labeled with a specific name, such as `wp_head`, corresponding to a part of the **WORDPRESS CORE** process (in the case of `wp_head`, the process of building the page’s HTML `<head>` section).
    
      
#### ACTION HOOKS
**ACTION HOOKS** tend to get dangled at milestones: for example, “you’re almost done building the page’s `<head>` section” for the `wp_head` **ACTION HOOK**, or “you’re almost done building the page’s `<body>` section” for the `wp_footer` **ACTION HOOK**.
  
#### FILTER HOOKS
**FILTER HOOKS** work a bit differently. **FILTER HOOKS** generally are very limited in what they do. They are called at a certain time to analyze (and possibly alter) a specific piece of data. Such as removing any empty `<p></p>` tags than can be created from the WYSIWYG editor. 

