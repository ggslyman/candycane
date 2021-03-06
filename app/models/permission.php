<?php
/* vim: fenc=utf8 ff=unix
 *
 *
 */

class Permission extends AppModel
{
  var $name = "Permission";
  var $useTable = false;
  var $permissions = array();

  function Permission()
  {
    $this->set('view_project', array('projects' => array('show', 'activity')), array('public' => true));
    $this->set('search_project', array('search' => 'index'), array('public' => true));
    $this->set('edit_project', array('projects' => array('settings', 'edit')), array('require' => 'member'));
    $this->set('select_project_modules', array('projects' => 'modules'), array('require' => 'member'));
    $this->set('manage_members', array('projects' => 'settings', 'members' => array('new', 'edit', 'destroy')), array('require' => 'member'));
    $this->set('manage_versions', array('projects' => array('settings', 'add_version'),'versions' => array('edit', 'destroy')), array('require' => 'member'));

  // map.project_module 'issue'_tracking do |map|);
    # Issue categories);
    $this->set('manage_categories', array('projects' => array('settings', 'add_issue_category'), array('issue_categories' => array('edit', 'destroy'))), array('require' => 'member'), 'issue_tracking');
    # Issues);
    $this->set('view_issues', array('projects' => array('changelog', 'roadmap'),
                                  'issues' => array('index', 'changes', 'show', 'context_menu'),
                                  'versions' => array('show', 'status_by'),
                                  'queries' => 'index',
                                  'reports' => 'issue_report'), array('public' => true), 'issue_tracking');
    $this->set('add_issues', array('issues' => 'new'), array(), 'issue_tracking');
    $this->set('edit_issues', array('issues' => array('edit', 'reply', 'bulk_edit')), array(), 'issue_tracking');
    $this->set('manage_issue_relations', array('issue_relations' => array('new', 'destroy')), array(), 'issue_tracking');
    $this->set('add_issue_notes', array('issues' => array('edit', 'reply')), array(), 'issue_tracking');
    $this->set('edit_issue_notes', array('journals' => 'edit'), array('require' => 'loggedin'), 'issue_tracking');
    $this->set('edit_own_issue_notes', array('journals' => 'edit'), array('require' => 'loggedin'), 'issue_tracking');
    $this->set('move_issues', array('issues' => 'move'), array('require' => 'loggedin'), 'issue_tracking');
    $this->set('delete_issues', array('issues' => 'destroy'), array('require' => 'member'), 'issue_tracking');
    # Queries
    $this->set('manage_public_queries', array('queries' => array('new', 'edit', 'destroy')), array('require' => 'member'), 'issue_tracking');
    $this->set('save_queries', array('queries' => array('new', 'edit', 'destroy')), array('require' => 'loggedin'), 'issue_tracking');
    # Gantt & calendar
    $this->set('view_gantt', array('issues' => 'gantt'), array(), 'issue_tracking');
    $this->set('view_calendar', array('issues' => 'calendar'), array(), 'issue_tracking');
    # Watchers
    $this->set('view_issue_watchers', array(), array(), 'issue_tracking');
    $this->set('add_issue_watchers', array('watchers' => 'new'), array(), 'issue_tracking');
  // end

  // map.project_module 'time'_tracking do |map|);
    $this->set('log_time', array('timelog' => 'edit'), array('require' => 'loggedin'), 'time_tracking');
    $this->set('view_time_entries', array('timelog' => array('details', 'report')), array(), 'time_tracking');
    $this->set('edit_time_entries', array('timelog' => array('edit', 'destroy')), array('require' => 'member'), 'time_tracking');
    $this->set('edit_own_time_entries', array('timelog' => array('edit', 'destroy')), array('require' => 'loggedin'), 'time_tracking');
//  end);

//  map.project_module 'news' do |map|);
    $this->set('manage_news', array('news' => array('new', 'edit', 'destroy', 'destroy_comment')), array('require' => 'member'), 'news');
    $this->set('view_news', array('news' => array('index', 'show')), array('public' => true), 'news');
    $this->set('comment_news', array('news' => 'add_comment'), array(), 'news');
//  end);

//  map.project_module 'documents' do |map|);
    $this->set('manage_documents', array('documents' => array('new', 'edit', 'destroy', 'add_attachment')), array('require' => 'loggedin'), 'documents');
    $this->set('view_documents', array('documents' => array('index', 'show', 'download')), array(), 'documents');
  // end

//  map.project_module 'files' do |map|);
    $this->set('manage_files', array('projects' => 'add_file'), array('require' => 'loggedin'), 'files');
    $this->set('view_files', array('projects' => 'list_files', 'versions' => 'download'), array(), 'files');
//  end

//  map.project_module 'wiki' do |map|);
    $this->set('manage_wiki', array('wikis' => array('edit', 'destroy')), array('require' => 'member'), 'wiki');
    $this->set('rename_wiki_pages', array('wiki' => 'rename'), array('require' => 'member'), 'wiki');
    $this->set('delete_wiki_pages', array('wiki' => 'destroy'), array('require' => 'member'), 'wiki');
    $this->set('view_wiki_pages', array('wiki' => array('index', 'special')), array(), 'wiki');
    $this->set('view_wiki_edits', array('wiki' => array('history', 'diff', 'annotate')), array(), 'wiki');
    $this->set('edit_wiki_pages', array('wiki' => array('edit', 'preview', 'add_attachment')), array(), 'wiki');
    $this->set('delete_wiki_pages_attachments', array(), array(), 'wiki');
    $this->set('protect_wiki_pages', array('wiki' => 'protect'), array('require' => 'member'), 'wiki');
//  end);

//  map.project_module 'repository' do |map|);
    $this->set('manage_repository', array('repositories' => array('edit', 'committers', 'destroy')), array('require' => 'member'), 'repository');
    $this->set('browse_repository', array('repositories' => array('show', 'browse', 'entry', 'annotate', 'changes', 'diff', 'stats', 'graph')), array(), 'repository');
    $this->set('view_changesets', array('repositories' => array('show', 'revisions', 'revision')), array(), 'repository');
    $this->set('commit_access', array(), array(), 'repository');
  // end);

  // map.project_module 'boards' do |map|);
    $this->set('manage_boards', array('boards' => array('new', 'edit', 'destroy')), array('require' => 'member'), 'boards');
    $this->set('view_messages', array('boards' => array('index', 'show'), array('messages' => array('show'))), array('public' => true), 'boards');
    $this->set('add_messages', array('messages' => array('new', 'reply', 'quote')), array(), 'boards');
    $this->set('edit_messages', array('messages' => 'edit'), array('require' => 'member'), 'boards');
    $this->set('edit_own_messages', array('messages' => 'edit'), array('require' => 'loggedin'), 'boards');
    $this->set('delete_messages', array('messages' => 'destroy'), array('require' => 'member'), 'boards');
    $this->set('delete_own_messages', array('messages' => 'destroy'), array('require' => 'loggedin'), 'boards');
  // end)

  }

  function set($name, $hash, $options = array(), $module = null)
  {
    $permission = array('name'=>$name);
    $actions = array();
    foreach($hash as $controller=>$value) {
      if (is_array($value)) {
        foreach($value as $action) {
          $actions[] = $controller.'/'.$action;
        }
      } else {
        $actions[] = $controller.'/'.$value;
      }
    }
    $permission['actions'] = $actions;
    $permission['require'] = isset($options['require']) ? $options['require'] : null;
    $permission['public']  = isset($options['public']) ? $options['public'] : false;
    $permission['project_module']  = $module;
    $permission['project_module']  = isset($options['project_module']) ? $options['project_module'] : $permission['project_module'];

    $this->permissions[$module][$name] = $permission;
  }

  /**
   * Returns the permission of given name or nil if it wasn't found
   * Argument should be a symbol
   * name of redmine is permission(name)
   */
  function findByName($name) {
    foreach($this->permissions as $permission) {
      if (!empty($permission[$name])) {
        return $permission[$name];
      }
    }
    return array();
  }

  function available_project_modules()
  {
    $modules = array();
    foreach($this->permissions as $module=>$permission) {
      if ($module != null) {
        $modules[$module] = $module;
      }
    }

    return $modules;
  }

  // from role.php
  function setable_permissions_name($builtin = null)
  {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $p) {
        if ($p['public'] != true) {
          switch ($builtin) {
          case 1:
            if ($p['require'] != 'member') { $tmp[] = ':' . $p['name']; }
            break;
          case 2:
            if (($p['require'] != 'loggedin')&&($p['require'] != 'member')) { $tmp[] = ':' . $p['name']; }
            break;
          default:
            $tmp[] = ':' . $p['name'];
          }
          
        }
      }
    }
    return $tmp;
  }

  // from role.php
  function setable_permissions($builtin = null)
  {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $p) {
        if ($p['public'] != true) {
          if (($builtin == 1) && ($p['require'] != 'member')) {
            continue;
          }
          if (($builtin == 2) && ($p['require'] != 'loggedin')) {
            continue;
          }
          $tmp[$module][ $p['name'] ] = $this->permissions[$module][ $p['name'] ];
        }
      }
    }
    return $tmp;
  }


  function non_member_permissions() {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $p) {
        if ($p['require'] == 'member') {
          $tmp[$module][ $p['name'] ] = $this->permissions[$module][ $p['name'] ];
        }
      }
    }
    return $tmp;
  }

  function non_public_permissions() {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $p) {
        if ($p['public'] != true) {
          $tmp[$module][ $p['name'] ] = $this->permissions[$module][ $p['name'] ];
        }
      }
    }
    return $tmp;
  }

  function public_permissions() {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $name => $p) {
        if ($p['public']) {
          $tmp[$module][$name] = $this->permissions[$module][$name];
        }
      }
    }
    return $tmp;
  }
      

  # Returns the actions that are allowed by the permission of given name
  function allowed_actions($permission_name) {
    $perm = $this->findByName($permission_name);
    return $perm ? $perm['actions'] : array();
  }

  function modules_permissions($modules) {
    $tmp = array();
    foreach ($this->permissions as $module => $perms) {
      foreach ($perms as $name => $p) {
        if (($p['project_module'] == null) || in_array($p['project_module'], $modules)) {
          $tmp[$module][$name] = $this->permissions[$module][$name];
        }
      }
    }
    return $tmp;
  }
}
