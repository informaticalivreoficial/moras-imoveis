<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    ConfigController,
    EmailController,
    PropertyController,
    TemplateController,
    UserController
};
use App\Http\Controllers\Web\{
    FeedController,
    Webcontroller
};

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    Route::get('/', [Webcontroller::class, 'home'])->name('home');

    /** FEED */
    Route::get('feed', [FeedController::class, 'feed'])->name('feed');
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

    /** Página de Compra - Específica de um imóvel */
    Route::match(['get', 'post'],'/imoveis/quero-comprar/{slug}', [WebController::class, 'buyProperty'])->name('buyProperty');
});

Route::prefix('admin')->middleware('auth')->group( function(){

    Route::get('/', [AdminController::class, 'home'])->name('home');

    //******************************* Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    
    Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    Route::get('listas/email/set-status', [NewsletterController::class, 'emailSetStatus'])->name('emails.emailSetStatus');
    Route::get('listas/email/delete', [NewsletterController::class, 'emailDelete'])->name('emails.delete');
    Route::delete('listas/email/deleteon', [NewsletterController::class, 'emailDeleteon'])->name('emails.deleteon');
    Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    
    //****************************** Configurações ***************************************/
    Route::put('configuracoes/{config}', [ConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [ConfigController::class, 'editar'])->name('configuracoes.editar');

    
    
    //******************* Templates ************************************************/
    Route::get('templates/set-status', [TemplateController::class, 'templateSetStatus'])->name('templates.templateSetStatus');
    Route::get('templates/delete', [TemplateController::class, 'delete'])->name('templates.delete');
    Route::delete('templates/deleteon', [TemplateController::class, 'deleteon'])->name('templates.deleteon');
    Route::put('templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    Route::get('templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::get('templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('templates/store', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');

    /** Imóveis */
    Route::match(['post', 'get'], 'imoveis/destaque', [PropertyController::class, 'destaqueMark'])->name('imoveis.destaque');
    Route::get('imoveis/marcadagua', [PropertyController::class, 'imageWatermark'])->name('imoveis.marcadagua');
    Route::get('imoveis/delete', [PropertyController::class, 'delete'])->name('imoveis.delete');
    Route::delete('imoveis/deleteon', [PropertyController::class, 'deleteon'])->name('imoveis.deleteon');
    Route::post('imoveis/image-set-cover', [PropertyController::class, 'imageSetCover'])->name('imoveis.imageSetCover');
    Route::get('imoveis/set-status', [PropertyController::class, 'setStatus'])->name('imoveis.setStatus');
    Route::delete('imoveis/image-remove', [PropertyController::class, 'imageRemove'])->name('imoveis.imageRemove');
    Route::put('imoveis/{imovel}', [PropertyController::class, 'update'])->name('imoveis.update');
    Route::get('imoveis/{imovel}/edit', [PropertyController::class, 'edit'])->name('imoveis.edit');
    Route::get('imoveis/create', [PropertyController::class, 'create'])->name('imoveis.create');
    Route::post('imoveis/store', [PropertyController::class, 'store'])->name('imoveis.store');
    Route::get('imoveis', [PropertyController::class, 'index'])->name('imoveis.index');

    //*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team')->middleware('can:time');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('clientes', [UserController::class, 'index'])->name('users.index');  

    Route::view('posts/create', 'admin.posts.create');

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

});


Auth::routes();
