<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\User;
use DateTime;
use frontend\models\Block;
use frontend\models\ContactForm;
use frontend\models\Investor;
use frontend\models\Miner;
use frontend\models\Node;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\Transaction;
use Yii;
use Yii\base\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\components\Helper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $getUsersQuery = [];
        $getChainResponse = [];
        $getNodesResponse = [];
        try {
            $getChainResponse = (Yii::$app->pandora->getHttpClient()->get('/chain/get_chain')->send())->data;
            $getNodesResponse = Yii::$app->pandora->getHttpClient()->get('nodes/get_nodes')->send();
            if ($getNodesResponse->isOk) {
                $getUsersQuery = (new Query())
                    ->select(['user.id', 'auth_assignment.item_name', 'user.username', 'profile.name'])
                    ->from('profile')
                    ->innerJoin('user', 'user.id=profile.user_id')
                    ->innerJoin('node', 'user.id=node.user_id')
                    ->innerJoin('auth_assignment', 'user.id=auth_assignment.user_id')
                    ->where(['node.node_address' => $getNodesResponse->data['nodes']])
                    ->all();
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', ' Ai grijă ca rețeaua ta să fie pornită !');
        }

        $chartUserByRoles =
            [
                'type' => 'pie',
                'id' => 'userByRolePie',
                'options' => [
                    'height' => 340,
                    'width' => 600,
                ],
                'data' => [
                    'radius' => "90%",
                    'labels' => ['Investitori', 'Mineri'], // Your labels
                    'datasets' => [
                        [
                            'data' => [Investor::find()->count(), Miner::find()->count()], // Your dataset
                            'label' => '',
                            'backgroundColor' => [
                                '#00BCD4',
                                '#EC417B',
                                'rgba(190, 124, 145, 0.8)',
                            ],
                            'borderColor' => [
                                '#fff',
                                '#fff',

                            ],
                            'borderWidth' => 1,
                            'hoverBorderColor' => ["#999", "#999"],
                        ],
                    ],
                ],
                'clientOptions' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                        'labels' => [
                            'fontSize' => 14,
                            'fontColor' => "#425062",
                        ],
                    ],
                    'tooltips' => [
                        'enabled' => true,
                        'intersect' => true,
                    ],
                    'hover' => [
                        'mode' => false,
                    ],
                    'maintainAspectRatio' => false,

                    'plugins' =>
                        new \yii\web\JsExpression("
                [{
                    afterDatasetsDraw: function(chart, easing) {
                        var ctx = chart.ctx;
                        chart.data.datasets.forEach(function (dataset, i) {
                            var meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                meta.data.forEach(function(element, index) {
                                    // Draw the text in black, with the specified font
                                    ctx.fillStyle = 'rgb(0, 0, 0)';

                                    var fontSize = 16;
                                    var fontStyle = 'normal';
                                    var fontFamily = 'Helvetica';
                                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                    // Just naively convert to string for now
                                    var dataString = dataset.data[index].toString()+'%';

                                    // Make sure alignment settings are correct
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';

                                    var padding = 5;
                                    var position = element.tooltipPosition();
                                    ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                                });
                            }
                        });
                    }
                }]"),
                ],
            ];
        $blocksNumberChartLabels = [];
        $blocksNumberChartValues = [];
        $months = Helper::getMonths();
        foreach ($months as $month) {
            $block = Block::find()->where(["DATE_FORMAT(timestamp, '%M' )" => $month])->count();
            array_push($blocksNumberChartLabels, $month);
            array_push($blocksNumberChartValues, $block ? $block : null);

        }
        $chainGrowChart = [
            'type' => 'line',
            'options' => [
                'height' => 119,
                'width' => 400,

            ],
            'data' => [
                'labels' => $blocksNumberChartLabels,

                'datasets' => [
                    [
                        'label' => "Blocuri minate",
                        'backgroundColor' => "rgba(0,0,255)",
                        'borderColor' => "rgba(0,0,255)",
                        'pointBackgroundColor' => "rgba(0,0,255)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(0,0,255)",
                        'data' => $blocksNumberChartValues,
                    ],
                ],

            ],
            'clientOptions' => [
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'stepSize'=>1,
                            'min' => 0,
                        ]
                    ]],
                ],
            ]
        ];
        $transactionChartLabels = [];
        $transactionChartValues = [];
        $currentMonthDates = Helper::getDaysOfTheCurrentMonth();

        foreach ($currentMonthDates as $date) {
            $transaction = Transaction::find()->where('MONTH(valid_at)=MONTH(NOW())')->andWhere(['DATE(valid_at)' => $date])->count();
            array_push($transactionChartLabels, date_format(new \DateTime($date), 'd F, Y'));
            array_push($transactionChartValues, $transaction ? $transaction : 0);
        }

//        Helper::debug($transactionChartLabels);
        $transactionsConfirmedPerDayChart = [
            'type' => 'bar',

            'options' => [
                'height' => 119,
                'width' => 400,
            ],
            'data' => [
                'labels' => $transactionChartLabels,
                'datasets' => [
                    [
                        'label' => "Tranzacții confirmate",
                        'backgroundColor' => "rgba(128,0,128)",
                        'borderColor' => "rgba(128,0,128)",
                        'pointBackgroundColor' => "rgba(128,0,128)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(128,0,128)",
                        'data' => $transactionChartValues,
                    ],
                ],
            ],
            'clientOptions' => [
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'stepSize'=>1,
                            'min' => 0,
                        ]
                    ]],
                ],
            ]
        ];
        return $this->render('index',
            ['getUsersQuery' => $getUsersQuery,
                'getChainResponse' => $getChainResponse,
                'chartUserByRoles' => $chartUserByRoles,
                'chainGrowChart' => $chainGrowChart,
                'transactionsConfirmedPerDayChart' => $transactionsConfirmedPerDayChart]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Confirma rolul de miner sau de investitor.
     * @param string $username
     * @return mixed
     */
    public function actionConfirmRole($username)
    {
        return $this->render('confirm-role', ['username' => $username]);
    }

    /**
     * Confirma rolul de miner sau de investitor.
     * @param string $user
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirmareMiner($username)
    {
        try {
            $date = new DateTime();
            $user = User::findOne(['username' => $username]);
            $nodeModel = new Node();

            // Asignez utilizatorul ca si miner si ii creez un nod nou
            $model = new Miner();
            $model->user_id = $user->id;
            $model->created_at = $date->format('Y-m-d H:i:s');
            $model->save();

            $port = (5000 + $user->id);

            $nodeModel->user_id = $user->id;
            $nodeModel->node_address = "127.0.0.1:" . $port;
            $nodeModel->save();

            if (!copy(Yii::getAlias('@frontend/web/nodes/blockchain.py'), Yii::getAlias('@frontend/web/nodes/blockchain_node_' . $port . '.py'))) {
                Yii::$app->session->setFlash('error', 'A aparut o eroare la inregistrarea nodului.');
            }
            $node = \Yii::$app->basePath . '/web/nodes/blockchain_node_' . $port . ".py";
            if (file_exists($node)) {
                exec("start $node");
            }

            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('Miner');
            $auth->assign($authorRole, $user->getId());

        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->render('message', [
            'message' => \Yii::t('user', 'Contul dumneavostra a fost creat. Ati ales sa deveniti miner. Multumim ca doriti sa dezvoltati si sustine reteaua noastra.'),
        ]);
    }

    /**
     * Confirma rolul de miner sau de investitor.
     * @param string $user
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirmareInvestitor($username)
    {
        try {
            $date = new DateTime();
            $user = User::findOne(['username' => $username]);
            $nodeModel = new Node();
            // Asignez utilizatorul ca si investitor si ii creez un nod nou
            $model = new Investor();
            $model->user_id = $user->id;
            $model->created_at = $date->format('Y-m-d H:i:s');
            $model->save();

            $port = (5000 + $user->id);

            $nodeModel->user_id = $user->id;
            $nodeModel->node_address = "127.0.0.1:" . $port;
            $nodeModel->save();

            if (!copy(Yii::getAlias('@frontend/web/nodes/blockchain.py'), Yii::getAlias('@frontend/web/nodes/blockchain_node_' . $port . '.py'))) {
                Yii::$app->session->setFlash('error', 'A aparut o eroare la inregistrarea nodului.');
            }
            $node = \Yii::$app->basePath . '/web/nodes/blockchain_node_' . $port . ".py";
            if (file_exists($node)) {
                exec("start $node");
            }

            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('Investitor');
            $auth->assign($authorRole, $user->getId());
        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->render('message', [
            'message' => \Yii::t('user', 'Contul dumneavostra a fost creat. Ati ales sa deveniti investitor. Multumim ca aveti incredere in potentialul retelei noastre.'),
        ]);

    }
}
