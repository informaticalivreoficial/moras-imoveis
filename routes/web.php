<?php

use App\Http\Controllers\Admin\{
    AdminController,
    EmailController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware('auth')->group( function(){

    Route::get('/', [AdminController::class, 'home'])->name('home');

    //******************************* Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    //******************************* Newsletter *********************************************/
    Route::match(['post', 'get'], 'listas/padrao', [NewsletterController::class, 'padraoMark'])->name('listas.padrao');
    Route::get('listas/set-status', [NewsletterController::class, 'listaSetStatus'])->name('listas.listaSetStatus');
    Route::get('listas/delete', [NewsletterController::class, 'listaDelete'])->name('listas.delete');
    Route::delete('listas/deleteon', [NewsletterController::class, 'listaDeleteon'])->name('listas.deleteon');
    Route::put('listas/{id}', [NewsletterController::class, 'listasUpdate'])->name('listas.update');
    Route::get('listas/{id}/editar', [NewsletterController::class, 'listasEdit'])->name('listas.edit');
    Route::get('listas/cadastrar', [NewsletterController::class, 'listasCreate'])->name('listas.create');
    Route::post('listas/store', [NewsletterController::class, 'listasStore'])->name('listas.store');
    Route::get('listas', [NewsletterController::class, 'listas'])->name('listas');

    Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    Route::get('listas/email/set-status', [NewsletterController::class, 'emailSetStatus'])->name('emails.emailSetStatus');
    Route::get('listas/email/delete', [NewsletterController::class, 'emailDelete'])->name('emails.delete');
    Route::delete('listas/email/deleteon', [NewsletterController::class, 'emailDeleteon'])->name('emails.deleteon');
    Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************************* Assinatura *********************************************/
    Route::get('assinar-plano/reativar', [AssinaturaController::class, 'resume'])->name('assinatura.resume');
    Route::get('assinar-plano/cancela', [AssinaturaController::class, 'cancel'])->name('assinatura.cancel');
    Route::get('assinar-plano/invoice/{invoice}', [AssinaturaController::class, 'downloadInvoice'])->name('assinatura.downloadInvoice');
    Route::post('assinar-plano/store', [AssinaturaController::class, 'store'])->name('assinatura.store');
    Route::get('assinar-plano/checkout', [AssinaturaController::class, 'index'])->name('assinatura.index');
    Route::get('assinatura', [AssinaturaController::class, 'assinatura'])->name('assinatura')->middleware(['subscribed']);

    //****************************** Configurações ***************************************/
    Route::match(['post', 'get'], 'configuracoes/fetchCity', [TenantClientConfigController::class, 'fetchCity'])->name('configuracoes.fetchCity');
    Route::put('configuracoes/{config}', [TenantClientConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [TenantClientConfigController::class, 'editar'])->name('configuracoes.editar');

    
    //******************* Slides ************************************************/
    Route::get('slides/set-status', [SlideController::class, 'slideSetStatus'])->name('slides.slideSetStatus');
    Route::get('slides/delete', [SlideController::class, 'delete'])->name('slides.delete');
    Route::delete('slides/deleteon', [SlideController::class, 'deleteon'])->name('slides.deleteon');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::get('slides/{slide}/edit', [SlideController::class, 'edit'])->name('slides.edit');
    Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::post('slides/store', [SlideController::class, 'store'])->name('slides.store');
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');

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
    Route::match(['post', 'get'], 'imoveis/destaque', [ImovelController::class, 'destaqueMark'])->name('imoveis.destaque');
    Route::get('imoveis/marcadagua', [ImovelController::class, 'imageWatermark'])->name('imoveis.marcadagua');
    Route::match(['post', 'get'], 'imoveis/fetchCity', [ImovelController::class, 'fetchCity'])->name('imoveis.fetchCity');
    Route::get('imoveis/delete', [ImovelController::class, 'delete'])->name('imoveis.delete');
    Route::delete('imoveis/deleteon', [ImovelController::class, 'deleteon'])->name('imoveis.deleteon');
    Route::post('imoveis/image-set-cover', [ImovelController::class, 'imageSetCover'])->name('imoveis.imageSetCover');
    Route::get('imoveis/set-status', [ImovelController::class, 'imovelSetStatus'])->name('imoveis.imovelSetStatus');
    Route::delete('imoveis/image-remove', [ImovelController::class, 'imageRemove'])->name('imoveis.imageRemove');
    Route::put('imoveis/{imovel}', [ImovelController::class, 'update'])->name('imoveis.update');
    Route::get('imoveis/{imovel}/edit', [ImovelController::class, 'edit'])->name('imoveis.edit');
    Route::get('imoveis/create', [ImovelController::class, 'create'])->name('imoveis.create');
    Route::post('imoveis/store', [ImovelController::class, 'store'])->name('imoveis.store');
    Route::get('imoveis', [ImovelController::class, 'index'])->name('imoveis.index');

   

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

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
