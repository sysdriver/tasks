<?php
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  
  <?php if (!$page): ?>
  
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
	 
  <?php endif; ?>
 
  <?php print render($title_suffix); ?>
  

  <?php if ($display_submitted): ?>
    <span class="submitted"><?php print $submitted ?></span>
  <?php endif; ?>
  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      //print_r($content);
	 // die;
    ?>
    <table border="1">
        <tr>
            <td colspan="2">
            <b>Описание</b>
            <hr />
            <?php 
            //WYSIWYG - change \n to html <br>
            $bd = explode("\n", $node->body['und'][0]['value']);
            $bd_out = implode("<br>", $bd);
            print $bd_out;
            ?>
            </td>

        </tr>
            <tr>
            <td>
                <?php 
                //print 'Дата: <font color="blue">'.date('Y.m.d',strtotime($content['field_date_create']['#items'][0]['value'])).'</font>';
                        print 'Дата создания: <font color="blue">'.date('d.m.Y',($node->created)).'</font>';
                ?>
            </td>
            <td>
                <?php 
                //print 'Время: <font color="blue">'.date('H:i',strtotime($content['field_date_create']['#items'][0]['value'])).'</font>'; 
                print 'Время: <font color="blue">'.date('H:i',($node->created)).'</font>';
            ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим все категории
                $ctgrs = '';
                foreach($content['field_category']['#items'] as $itm) {
                        if($itm['taxonomy_term']->vocabulary_machine_name == 'categories')
                                $ctgrs .= $itm['taxonomy_term']->name.', ';
                }
                print 'Категории: <font color="blue">'.$ctgrs.'</font>';
                unset($ctgrs);	
                ?>
            </td>
            <td>
                <?php 
                //Выводим всех пользователей
                $usrs = '';
                foreach($content['field_user']['#items'] as $usr) {
                        $usrs .= $usr['user']->name.', ';
                }
                print 'Пользователи: <font color="blue">'.$usrs.'</font>' ;
                unset($usrs);
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим все группы пользователей
                $grps = '';
                if(!empty($content['field_user_group']))
                        foreach($content['field_user_group']['#items'] as $itm) {
                                $grps .= $itm['taxonomy_term']->name.', ';
                }

                print 'Группы пользователей: <font color="blue">'.$grps.'</font>';
                unset($grps);	
                ?>
            </td>
            <td>
                <?php 
                //Выводим очередь
                print 'Очередь: <font color="blue">'.$content['field_queue']['#items'][0]['taxonomy_term']->name.'</font>';			
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим родителя, если есть
                if(!empty($content['field_parent_task']))
                        print 'Родитель: <font color="blue"><a href="'.$content['field_parent_task']['#items'][0]['node']->nid.'">'.$content['field_parent_task']['#items'][0]['node']->title.'</a></font>';
                else
                        print 'Родитель: <font color="blue">Нет родителя</font>';
                ?>		
            </td>
            <td>
                <?php 
                //Выводим все теги задач
                $tgs = '';
                if(!empty($content['field_task_tegs'])) {
                    foreach($content['field_task_tegs']['#items'] as $itm) {
                            if($itm['taxonomy_term']->vocabulary_machine_name == 'task_tegs')
                                    $tgs .= $itm['taxonomy_term']->name.', ';
                    }
                    print 'Теги задачи: <font color="blue">'.$tgs.'</font>';
                    unset($tgs);	
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //архивная задача
                if(!empty($content['field_task_archieve']['#items'][0]['value']))
                        print 'Архив: <font color="blue">да</font>';
                else
                        print 'Архив: <font color="blue">нет</font>';
                ?>
            </td>
            <td>
                <?php 
                //задача удалена
                if(!empty($content['field_task_delete']['#items'][0]['value']))
                        print 'Удалена: <font color="blue">да</font>';
                else
                        print 'Удалена: <font color="blue">нет</font>';
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим дату удаления, если есть
                if(!empty($content['field_date_delete']))
                    print 'Дата удаления: <font color="blue">'.date('Y.m.d',strtotime($content['field_date_delete']['#items'][0]['value'])).'</font>';
                else
                    print 'Дата удаления: <font color="blue">нет</font>';
                ?>
            </td>
            <td>
                <?php 
                //Выводим текущий статус
                if(!empty($content['field_task_status']))
                    print 'Статус: <font color="blue">'.$content['field_task_status']['#items'][0]['taxonomy_term']->name.'</font>';
                else
                    print 'Статус: <font color="blue">нет</font>';
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим тип
                if(!empty($content['field_task_type']))
                    print 'Тип задачи: <font color="blue">'.$content['field_task_type']['#items'][0]['taxonomy_term']->name.'</font>';
                else
                    print 'Тип задачи: <font color="blue">нет</font>';
                ?>
            </td>
            <td>
                <?php 
                //Выводим результат, @todo: добавить тип мат-ов (сущность) "Результат"
                if(!empty($content['field_task_result']))
                    print 'Результат: <font color="blue">'.$content['field_task_result']['#items'][0]['value'].'</font>';
                else
                    print 'Результат: <font color="blue">нет</font>';
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                //Выводим шаги
                if(!empty($content['field_task_steps']))
                    print 'Шаги: <font color="blue">'.$content['field_task_steps']['#items'][0]['value'].'</font>';
                else
                    print 'Шаги: <font color="blue">нет</font>';
                ?>
            </td>
            <td>
                <?php 
                //Выводим дату заверш.
                if(!empty($content['field_date_done']))
                        print 'Дата заверш.: <font color="blue"><b>'.date('Y.m.d',strtotime($content['field_date_done']['#items'][0]['value'])).'</b></font>';
                else
                        print 'Дата заверш.: <font color="blue">нет</font>';
                ?>
            </td>
        </tr>
    </table>
    <?php 
    //программный вывод views с заданными фильтрами
    global $user;
    $t_type = $content['field_task_type']['#items'][0]['taxonomy_term']->tid;
    $view = views_get_view('tasks_view');
    $display_id = 'page_1';
    $view->set_display($display_id);
    $item = $view->get_item($display_id, 'filter', 'field_task_type_tid');
    //print_r($item);
    //die;
    //$item['operator'] = 'and';
    //$item['value'] = array('value'=>'38'); 
    $item['value'] = array('value'=>$t_type); 
    //print_r($item);
    //die;			
    $view->set_item($display_id, 'filter', 'field_task_type_tid', $item);

    $view->set_items_per_page(3);
    //$view->set_arguments(array($pkt));
    $view->is_cacheable = FALSE;
    print $view->render();
    ?>
  </div>

  <div class="clearfix">
    <?php if (!empty($content['links'])): ?>
      <div class="links"><?php print render($content['links']); ?></div>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  </div>

</div>