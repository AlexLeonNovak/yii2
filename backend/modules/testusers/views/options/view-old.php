<?php foreach ($user_answers as $user_answer) { ?>
        <div class="panel panel-default">
            <div class="panel-heading"><?= $user_answer->question->question; ?></div>
    <?php if (empty($user_answer->answer->id)) { ?>
                <div class="text-danger bg-danger" style="padding:10px;">
                    <strong>
                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
                    </strong>
                    Сотрудник не ответил на этот вопрос
                </div>
            <?php } ?>
            <?=
            GridView::widget([
                'layout' => "{items}",
                'dataProvider' => $dataProviderAnswers[$user_answer->id],
//                'rowOptions' => function($model) use ($user_answer) {
//                    if (isset($user_answer->answer->answer)) {
//                        if ($model->answer == $user_answer->answer->answer) {
//                            if ($user_answer->answer->correct) {
//                                return ['class' => 'success'];
//                            } else {
//                                return ['class' => 'danger'];
//                            }
//                        }
//                    }
//                },
                'columns' => [
                    [
                        'format' => 'raw',
                        'value' => function ($model) use ($user_answer) {
                            if (isset($user_answer->answer->answer)) {
                                var_dump($user_answer->answer->answer);
                                echo '<br>';
                                if ($model->answer == $user_answer->answer->answer) {
                                    if ($model->correct) {
                                        return '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
                                    } else {
                                        return '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>';
                                    }
                                }
                            }
                            return '';
                            
                        },
                        'contentOptions' => function($model) {
                            if ($model->correct) {
                                return ['class' => 'success'];
                            } else { // в PHP 7.2 ошибка, count(null) не проходит
                                return ['class' => 'default'];
                            }
                        },
                        'label' => 'Ответ СОТР',
                        'contentOptions' => [
                            'class' => 'text-center col-md-2',
                        ]
                    ],
                    [
                        'value' => 'answer',
                        'contentOptions' => function($model) {
                            if ($model->correct) {
                                return ['class' => 'success'];
                            } else { // в PHP 7.2 ошибка, count(null) не проходит
                                return ['class' => 'default'];
                            }
                        },
                        'label' => 'Все ответы',
                    ],
                ]
            ]);
            ?>

        </div>
<?php } ?>