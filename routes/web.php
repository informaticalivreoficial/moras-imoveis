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
    FilterController,
    SendEmailController,
    Webcontroller
};
use App\Livewire\Contact;
use App\Livewire\Home;

// Route::get('/teste', function() {
//     return storage_path();
// });
Route::get('/', Home::class);

//CLIENTE
Route::get('/atendimento', Contact::class)->name('contact');

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    //Route::get('/', Home::class);

    /** FEED */
    Route::get('feed', [FeedController::class, 'feed'])->name('feed');
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

    /** Página de Compra - Específica de um imóvel */
    Route::match(['get', 'post'],'/imoveis/quero-comprar/{slug}', [WebController::class, 'buyProperty'])->name('buyProperty');

    /** Página de Locaçãp - Específica de um imóvel */
    Route::get('/quero-alugar/{slug}', [WebController::class, 'rentProperty'])->name('rentProperty');

    /** Lista todos os imóveis */
    Route::get('/imoveis/{type}', [WebController::class, 'propertyList'])->name('propertyList');

    /** Página de Experiências - Específica de uma categoria */
    Route::get('/experiencias/{slug}', [FilterController::class, 'experienceCategory'])->name('experienceCategory');

    /** Pesquisa */
    Route::get('/pesquisar-imoveis', [SiteController::class, 'pesquisaImoveis'])->name('pesquisar-imoveis');
    Route::match(['post', 'get'], '/pesquisa', [SiteController::class, 'pesquisaImoveis'])->name('pesquisa');

    //CLIENTE
    //Route::get('/atendimento', [SendEmailController::class, 'contact'])->name('contact');
    Route::post('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/sendNewsletter', [SendEmailController::class, 'sendNewsletter'])->name('sendNewsletter');
    Route::get('/sendReserva', [SendEmailController::class, 'sendReserva'])->name('sendReserva');

    //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [SiteController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [SiteController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog/artigos', [SiteController::class, 'artigos'])->name('blog.artigos');    
    Route::match(['get', 'post'],'/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    //****************************** Notícias ***********************************************/
    Route::get('/noticia/{slug}', [SiteController::class, 'noticia'])->name('noticia');
    Route::get('/noticias/categoria/{slug}', [SiteController::class, 'categoria'])->name('noticia.categoria');
    Route::get('/noticias', [SiteController::class, 'noticias'])->name('noticias'); 

    //****************************** Páginas ***********************************************/
    Route::get('/pagina/{slug}', [SiteController::class, 'pagina'])->name('pagina');

    //FILTROS
    Route::post('main-filter/search', [FilterController::class, 'search'])->name('main-filter.search');
    Route::post('main-filter/categoria', [FilterController::class, 'categoria'])->name('main-filter.categoria');
    Route::post('main-filter/tipo', [FilterController::class, 'tipo'])->name('main-filter.tipo');
    Route::post('main-filter/bairro', [FilterController::class, 'bairro'])->name('main-filter.bairro');
    Route::post('main-filter/dormitorios', [FilterController::class, 'dormitorios'])->name('main-filter.dormitorios');
    Route::post('main-filter/suites', [FilterController::class, 'suites'])->name('main-filter.suites');
    Route::post('main-filter/banheiros', [FilterController::class, 'banheiros'])->name('main-filter.banheiros');
    Route::post('main-filter/garagem', [FilterController::class, 'garagem'])->name('main-filter.garagem');
    Route::post('main-filter/price-base', [FilterController::class, 'priceBase'])->name('main-filter.priceBase');
    Route::post('main-filter/price-limit', [FilterController::class, 'priceLimit'])->name('main-filter.priceLimit');
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
    Route::match(['post', 'get'], 'imoveis/destaque', [PropertyController::class, 'highlightMark'])->name('property.highlight');
    Route::match(['get', 'post'], 'imoveis/pesquisa', [PropertyController::class, 'search'])->name('property.search');
    Route::get('imoveis/marcadagua', [PropertyController::class, 'imageWatermark'])->name('property.watermark');
    Route::get('imoveis/delete', [PropertyController::class, 'delete'])->name('property.delete');
    Route::delete('imoveis/deleteon', [PropertyController::class, 'deleteon'])->name('property.deleteon');
    Route::post('imoveis/image-set-cover', [PropertyController::class, 'setCover'])->name('property.setCover');
    Route::get('imoveis/set-status', [PropertyController::class, 'setStatus'])->name('property.setStatus');
    Route::delete('imoveis/image-remove', [PropertyController::class, 'imageRemove'])->name('property.imageRemove');
    Route::put('imoveis/{id}', [PropertyController::class, 'update'])->name('property.update');
    Route::get('imoveis/{id}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::get('imoveis/create', [PropertyController::class, 'create'])->name('property.create');
    Route::post('imoveis/store', [PropertyController::class, 'store'])->name('property.store');
    Route::get('imoveis', [PropertyController::class, 'index'])->name('properties.index');

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
