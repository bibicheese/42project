<?php

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\App;

return function (App $app) {
  $app->get('/api/active', \Src\Action\ActiveAction::class);
  $app->post('/api/create_user', \Src\Action\UserCreateAction::class);
  $app->post('/api/login', \Src\Action\UserLoginAction::class);
  $app->get('/api/logout', \Src\Action\UserLogoutAction::class);
  $app->post('/api/account_editor', \Src\Action\UserDataAccEditAction::class);
  $app->post('/api/recovery_password', \Src\Action\RecoveryPasswordAction::class);
  $app->post('/api/images', \Src\Action\UploadImagesAction::class);
  $app->get('/api/profil/{login}', \Src\Action\ViewProfilAction::class);
  $app->get('/api/suggest_list', \Src\Action\ListSuggestionAction::class);
  $app->post('/api/like', \Src\Action\UserLikeAction::class);
  $app->get('/api/my_account', \Src\Action\ViewSelfProfilAction::class);
  $app->get('/api/get_tags', \Src\Action\GetTagsAction::class);
};
