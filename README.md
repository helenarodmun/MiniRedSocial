<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



### DESARROLLO DE LAS DIFERENTES ETAPAS

##  A31. Tablas del proyecto y sistema de autenticaci??n

Como proyecto vamos a crear una mini red social en la que sus usuarios podr??n compartir enlaces de inter??s (una especie de Reddit o Men??ame pero simplificada). Estos recursos se podr??n votar y estar??n asociados a un canal o tem??tica concreta. Por lo tanto, la idea general de la funcionalidad es que un usuario pueda publicar un link vinculado a un canal.
Ejercicio 1. Tablas

Documentaci??n sobre migraciones: https://laravel.com/docs/9.x/migrations

Laravel utiliza las migraciones para poder definir y crear las tablas de la base de datos desde c??digo, y de esta manera tener un control de versiones de las mismas. Es muy c??modo, sobre todo cuando varios desarrolladores trabajan sobre una BBDD local que puede cambiar. As?? siempre trabajan todos con la misma base de datos.

Nuestro proyecto tendr?? tres tablas: community_links, channels y users.

ejecuta artisan para crear una migraci??n para la tabla community_links:

artisan make:migration create_community_links_table

Si todo va bien podremos ver la migraci??n en la carpeta de migraciones. En el m??todo create de la funci??n up de la migraci??n incluye los siguientes campos:

$table->id();
$table->integer('user_id')->index();
$table->integer('channel_id')->index();
$table->string('title');
$table->string('link')->unique();
$table->boolean('approved')->default(0);
$table->timestamps();

F??jate que se ha creado el m??todo up y down. En el m??todo down de la migraci??n se deshacen los cambios que se han hecho en el m??todo up. En este caso ser??a eliminar la tabla y ya viene codificado por defecto.

Facade: https://www.laraveltip.com/para-que-sirven-las-facades-en-laravel-explicadas-con-un-caso-real/

Creamos ahora la tabla channels:

artisan make:migration create_channels_table --create=channels

Y a??adimos sus campos:

$table->id();
$table->string('title');
$table->string('slug')->unique();
$table->string('color');
$table->timestamps();
Si ejecutamos artisan migrate probablemente no funcionar?? porque la BBDD est?? sin configurar.

Si est??s usando Laragon usa mysql. En caso contrario puedes usar sqlite. Es r??pida de configurar y c??moda de usar pero no sirve para un proyecto mediano o que requiera integridad referencial. En el .env debes borrar toda la informaci??n relativa a mysql y dejar la siguiente l??nea:

DB_CONNECTION=sqlite
Creamos el fichero de la BBDD:

touch database/database.sqlite

Y ejecutamos las migraciones con el comando artisan migrate.

Comprueba con el cli de sqlite que la tabla se ha creado correctamente: sqlite3 database/database.sqlite o con la interface de Laragon.

Ejercicio 2. Sistema de autenticaci??n

Vamos a necesitar usuarios registrados en nuestra aplicaci??n as?? que vamos a instalar Breeze, uno de los sistemas de autenticaci??n que trae incorporado Laravel. Breeze usa Tailwind como framework CSS, lo cual no impide que puedas usar Bootstrap en otras partes de tu proyecto.

Existe ya una migraci??n con el nombre create_users_table para la tabla users con todos los campos necesarios que crea Laravel por nosotros. Ejec??tala con artisan migrate.

Al instalar Breeze se generar?? un "scaffolding", es decir, una estructura b??sica que consiste en una serie de rutas y vistas predefinidas para el sistema de autenticaci??n. Para instalarlo teclea lo siguiente:

composer require laravel/breeze --dev (instalar?? el paquete)

php artisan breeze:install blade (blade es el motor de plantillas HTML por defecto de Laravel)

npm run dev

Comprueba que se han generado varias vistas en resources/views/auth.
Laravel trae incorporados varios controladores para las funciones de autenticaci??n. Est??n localizados en App\Http\Controllers\Auth. Para la mayor parte de aplicaciones no ser?? necesario modificar estos controladores. Identifica para qu?? sirve cada uno.
Ejecuta tambi??n el comando artisan route:list para ver las rutas que se han creado asociadas a estos controladores.
Comprueba que en el archivo de rutas web.php hay un include con las rutas para la autenticaci??n. Abre el archivo que contiene las rutas para la autenticaci??n, escoge alguna y expl??cala con tus palabras.
Ejercicio 3. Confirmar e-mail y recuperar password

Para implementar la confirmaci??n por correo cuando un usuario se registra vamos a usar mailtrap, que es un servidor de correo de prueba que evita tener que introducir direcciones de correo reales. Reg??strate en mailtrap y copia la configuraci??n para Laravel que deber??s incluir en tu fichero .env. Ahora cualquier correo que env??e Laravel se har?? a trav??s de mailtrap.

En el modelo User indicamos que implementamos el interface MustVerifyEmail:

class User extends Authenticatable implements MustVerifyEmail
Por ??ltimo, en el fichero web.php habilitamos el middleware para la verificaci??n de las rutas. En nuestro caso s??lo podremos acceder al dashboard si hemos verificado el correo-e:

Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

## A32. Primeras rutas, factories y relaciones entre tablas

Ejercicio 1. Primeras rutas

Vamos a crear las primeras rutas, controladores y vistas de la aplicaci??n que nos permitir??n ver todo el flujo MVC en Laravel. En otra pr??ctica profundizaremos un poco m??s en el sistema de rutas de Laravel.

El fichero donde se definen las rutas se llama web.php, dentro de la carpeta routes. Hay, adem??s, un fichero api.php espec??fico para las rutas de la API de nuestra app. Ejecuta artisan route:list para ver las rutas que ya tienes definidas. Ver??s las rutas del sistema de autenticaci??n, entre otras.

De momento vamos a crear dos rutas para nuestro proyecto, una para mostrar todos los enlaces que llamar?? al m??todo index mediante GET y otra para crear un link que llamar?? al m??todo store del controlador mediante POST:

Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);
Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store']);
El controlador CommunityLinkController no existe, as?? que cr??alo con su modelo asociado mediante artisan make:controller CommunityLinkController --model=CommunityLink.

El m??todo index del controlador devolver?? una vista index.blade.php:

return view('community/index');
Crea la vista en resources/views/community/index.blade.php. El motor de plantillas blade es muy potente y permite la herencia de plantillas. Laravel trae definido un layout por defecto que es el que vamos a usar en nuestra vista mediante la herencia:

@extends('layouts.app')
@section('content')
<h1>Community</h1>
@stop
En la plantilla app.blade.php tienes que cambiar la variable $slot por lo siguiente:

<main>
@yield('content')
</main>
Y en el fichero navigation.blade.php tienes que poner la directiva blade @auth y al final del mismo @endauth. Esto lo hacemos ya que la barra de navegaci??n s??lo la vamos a mostrar a los usuarios logueados.

En el fichero RouteServiceProvider de la carpeta app/providers cambia el valor de HOME a /community.

Ejercicio 2. Factories

Laravel permite generar datos de prueba para las tablas de manera autom??tica mediante factories y seeders: https://laravel.com/docs/9.x/database-testing#defining-model-factories.

Para el modelo User los factories ya est??n configurados, as?? que basta con abrir tinker (el REPL de Laravel), tecleando artisan tinker, y escribir lo siguiente para crear cinco usuarios de prueba:

User::factory()->count(5)->create()

Si tecleas User::all() ver??s los usuarios que se han creado (est??s usando Eloquent, el ORM de Laravel, al hacer User::all())

Para el modelo CommunityLink tenemos que crear nosotros un factory con artisan make:factory CommunityLinkFactory --model=CommunityLink.

Para que los campos se puedan rellenar autom??ticamente deben declararse como fillable en el modelo:

protected $fillable = [
  'user_id', 'channel_id', 'title', 'link', 'approved'
];
Adem??s, debemos a??adir los campos que queremos que se rellenen autom??ticamente en el m??todo definition de la clase CommunityLinkFactory:

return [
 'user_id' => \App\Models\User::all()->random()->id,
 'channel_id' => 1,
 'title' => $this->faker->sentence,
 'link' => $this->faker->url,
 'approved' => 0
];
La clase Faker tiene infinidad de tipos de datos: https://github.com/fzaninotto/Faker

A??ade en el m??todo run de la clase DatabaseSeeder la llamada al factory (resuelve las dependencias con use):

DB::delete('delete from community_links');
CommunityLink::factory()->count(50)->create(); 
Por ??ltimo, ejecuta artisan db:seed para generar los datos.

La clase DB es el QueryBuilder de Laravel: https://laravel.com/docs/9.x/queries

Ejercicio 3. Paginar resultados

Documentaci??n sobre paginaci??n: https://laravel.com/docs/9.x/pagination

Paginar resultados es muy sencillo en Laravel. Modifica el m??todo index del controlador:

public function index() {
  $links = CommunityLink::paginate(25);
  return view('community/index', compact('links'));
}
Y a??ade en el index.blade, en la secci??n content, lo siguiente:

@foreach ($links as $link)
<li>{{$link->title}}</li>
@endforeach
{{$links->links()}}
Ejercicio 4. Relaciones entre tablas

Documentaci??n sobre c??mo relacionar tablas en Eloquent: https://laravel.com/docs/9.x/eloquent-relationships.

 De momento, nos interesa mostrar junto con el link el nombre del autor y la fecha. Para ello vamos a relacionar las tablas. En el modelo CommunityLink crea el siguiente m??todo:

public function creator()
{
  return $this->belongsTo(User::class, 'user_id');
}
Y en la vista index.blade.php a??ade lo siguiente para cada link:

<small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>

## A34. Formulario para a??adir un link
Ejercicio 1. Proteger rutas

Comprueba si todas las rutas que hacen referencia a los controladores que has creado est??n protegidas por contrase??a. Puedes verlo mediante el comando artisan route:list -v  en la columna Middleware.

Comprueba que puedes acceder a alguna ruta no protegida sin introducir credenciales. Para evitar esto aplica el middleware auth a las rutas desprotegidas del controlador CommunityLinkController (->middleware('auth'))

Comprueba que ahora no tienes acceso a estas rutas sin haberte logueado.

Ejercicio 2. A??adir un link

A pesar de que Breeze utiliza Tailwind nosotros vamos a trabajar con Bootstrap. Incl??yelo por CDN en la vista:

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
 
Comprueba que ves la vista con los estilos de Bootstrap.

A la hora de subir un link a la BBDD tenemos que incluir el user_id y el channel_id, ya que est??n en la tabla community_link. Sin embargo, no est??n en el formulario. Lo haremos de la siguiente manera en el m??todo store:

public function store(Request $request) {
  request()->merge(['user_id' => Auth::id(), 'channel_id' => 1 ]);
  CommunityLink::create($request->all());
  return back();
}
El m??todo merge del objeto request (request()->merge) nos permite unir a la solicitud HTTP par??metros que no est??n inicialmente en la misma. Esto, por un lado, evita tener que pasar el user_id por un campo hidden del formulario (lo cual es poco deseable) o en la URL. El channel_id, de momento lo vamos a hardcodear, para simplificar.

Ejercicio 3. Objeto requets

Documentaci??n sobre el objeto Request en Laravel: https://laravel.com/docs/9.x/requests

En el m??todo store haz un dd($request) al principio del mismo. ??Qu?? hay en parameters? ??Qu?? obtiene el m??todo all()?

Dentro del m??todo store prueba los siguientes m??todos y explica qu?? hacen:

$request->path();
$request->url();
$request->input()
$request->fullUrl();
Ejercicio 4. Objeto response

Documentaci??n sobre el objeto Response en Laravel: https://laravel.com/docs/9.x/responses

Utiliza el helper response para devolver una cadena 'Respuesta' con c??digo 200. (return response('Respuesta', 200). Comprueba el c??digo HTTP con el inspector de c??digo del navegador, en la pesta??a network (recarga la p??gina si es necesario).

Prueba ahora a enviar la cadena "Error" y el c??digo 404. Comprueba el c??digo con el inspector de c??digo.

Ejercicio 5. Validaci??n

Documentaci??n sobre validaci??n en Laravel: https://laravel.com/docs/9.x/validation

Laravel tiene un sistema de valicaci??n muy sencillo. La clase Controller, de la cual hereda nuestro controlador CommunityController, usa la clase ValidatesRequests, lo cual significa que podemos usar todo el sistema de validaci??n de Laravel directamente en nuestro controlador. Incluye en el m??todo store lo siguiente:

$this->validate($request, [
  'title' => 'required',
  'link' => 'required|active_url'
]);
La gesti??n de errores en las vistas con Laravel tambi??n es muy sencilla. De hecho, podemos mostrar los errores en las vistas a trav??s de la variable $errors. Existe tambi??n la posibilidad de utilizar la directiva @errors de blade para mostrar los errores. Consulta el siguiente enlace y haz que se muestren los errores en el formulario: https://laravel.com/docs/9.x/blade#validation-errors

Ejercicio 6. Partial

Nos interesa poner el formulario para a??adir un link en un partial, para que la vista quede m??s clara. Por lo tanto, en la vista anterior crea un partial add-link.blade.php utilizando la directiva @include de blade.

## A35. Channels y persistencia de datos
Ejercicio 1. A??adir canales

Ya tenemos creados los modelos para los usuarios y para los enlaces. Nos falta el modelo para los canales y a??adir al formulario un desplegable para poder asociar un link a un canal o tem??tica concreta.

Crea el modelo Channel con artisan.

Intenta insertar un registro con tinker. Te dar?? un error, ya que los atributos del modelo tienen que ser fillable. Corr??gelo (recuerda c??mo lo hiciste con el modelo CommunityLink).

Modifica el m??todo store del controlador CommunityLinkController para que se valide el channel:

'channel_id' => 'required|exists:channels,id'
A??ade lo siguiente al m??todo index para pasarle a la vista todos los canales y poder mostrarlos ordenados en el formulario:

$channels = Channel::orderBy('title','asc')->get();
A??ade a la vista add-link.blade.php el siguiente c??digo para a??adir el desplegable al formulario:

<div class="form-group">
<label for="Channel">Channel:</label>
<select class="form-control @error('channel_id') is-invalid @enderror" name="channel_id">
<option selected disabled>Pick a Channel...</option>
@foreach ($channels as $channel)
<option value="{{ $channel->id }}">
{{ $channel->title }}
</option>
@endforeach
</select>
@error('channel_id')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
Comprueba que puedes a??adir un enlace y comprueba con Tinker que se creal el channel_id correspondiente (recuerda que lo ten??amos hardcodeado).

Ejercicio 2. Persistencia de datos

La persistencia de datos se consigue con el helper old. No puede ser m??s sencillo. Por ejemplo, para el campo title pondr??amos en el atributo value el valor old('title'):

value="{{old('title')}}"
Para el desplegable es un poco diferente y deberemos incluir lo siguiente en el atributo value de la etiqueta option:

<option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>

Intenta dar de alta un link con la misma URL. ??Qu?? sucede?

Para resolverlo a??ade en el controlador la siguiente validaci??n al link para que no salte el error:

'link' => 'required|active_url|unique:community_links'
Ejercicio 3. Relaci??n entre channel y link

Para poder mostrar el canal al que pertenece un link en la lista tenemos que relacionar los modelos CommunityLink y Channel. Es una relaci??n 1:N. Implem??ntala igual que hicimos con CommunityLink y User.

Ahora en la lista de links ya podemos a??adir el canal, por ejemplo, mediante una etiqueta span dentro de cada <li>:

<span class="label label-default" style="background: {{ $link->channel->color }}">
{{ $link->channel->title }}
</span>

## A36. Aprobar un link, usuarios verificados y flash messages
Nuestra aplicaci??n, tal y como est?? implementada, permite que se suba un link autom??ticamente, sin necesidad de ser aprobado por el administrador. Esto no es lo que queremos.

Adem??s, queremos que cuando un usuario sube, por ejemplo, tres links se convierta en usuario verificado y que no sea necesario que el administrador apruebe los links que suba a partir de ese momento.

Ejercicio 1. Mostrar s??lo los links aprobados

La primera funcionalidad es sencilla. Recuerda que nuestro modelo tiene un campo approved que, por defecto, es 0. Simplemente filtramos la consulta en el m??todo index para mostrar s??lo los links que est??n aprobados:

$links = CommunityLink::where('approved', 1)->paginate(25);

Utiliza @if en la vista blade para que si no hay ning??n link aprobado (count($links)) muestre "No contributions yet".

Ejercicio 2. Usuarios verificados

Para poder implementar esta funcionalidad vamos a a??adir a User un campo trusted que indicar?? si un usuario es verificado (se le han aprobado m??s de tres links) o no.

Podr??amos a??adir el campo a la migraci??n ya existente y hacer un reset o refresh de las migraciones, pero al realizar una modificaci??n en la migraci??n original tenemos el problema de que se eliminar?? el contenido de las tablas en la base de datos. Si estamos en modo desarrollo nos da igual. Es m??s, se aconseja hacerlo as?? para que el n??mero de migraciones no aumente innecesariamente. Sin embargo, lo vamos a hacer como si la aplicaci??n estuviera en producci??n para aprender c??mo ser??a. Por lo tanto, creamos  una nueva migraci??n y agregamos desde ah?? las modificaciones que necesitamos:

artisan make:migration add_trusted_to_users

A??adimos la columna en el m??todo up:

$table->boolean('trusted')->default(0);
F??jate que usamos el m??todo table de la facade Schema, en lugar de create, como hasta ahora.

En el m??todo down() especificamos la acci??n inversa por si necesitamos hacer un rollback:

$table->dropColumn('trusted');
Ejecuta la migraci??n con artisan migrate y comprueba con Tinker que se ha creado la nueva columna.

Modificamos el m??todo store para hacer las comprobaciones oportunas:

$approved = Auth::user()->trusted ? true : false;
request()->merge(['user_id' => Auth::id(), 'approved'=>$approved]);
Comprueba que un usuario no verificado no puede publicar directamente.

Con tinker convierte un usuario en verificado ($u->User::first();$u->trusted=true;$u->save()) y comprueba que los links que env??a se aprueban autom??ticamente.

Para mejorar un poco la encapsulaci??n crea un m??todo isTrusted en el User que devuelva el atributo trusted, en lugar de acceder directamente al campo trusted de User.

Ejercicio 3. Mensajes flash

No le estamos dando feedback al usuario cuando crea un link, tanto si este se ha aprobado como si no. Vamos a implementarlo con mensajes flash. Consulta el siguiente tutorial para hacerlo: https://www.itsolutionstuff.com/post/laravel-8-flash-message-tutorial-exampleexample.html.

Comprueba que se muestan los mensajes correspondientes tanto para un usuario verificado como para uno no verificado.

Antes de continuar con la siguiente pr??ctica crea tu propio archivo css en la carpeta public y dale estilo a la p??gina

## A37. Timestamps y validaci??n mediante FormRequest
Ejercicio 1. Timestamps
Nos interesa ampliar la funcionalidad de la app, de tal manera que si un usuario env??a un link que ya existe se debe actualiza el timestamp y, por lo tanto, ese link aparecer?? el primero en la lista. Adem??s, se informar?? mediante un flash de lo que ha sucedido. El campo t??tulo y el campo autor no se actualizar??n.
Antes de nada lo que tenemos que hacer es ordenar la consulta para que aparezcan los ??ltimos registros primero:
$links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
El m??todo latest ordena por ??ltima fecha de creaci??n, no de actualizaci??n. Por eso le hemos pasado el argumento updated_at.
Lo siguiente que tenemos que hacer es quitar la validaci??n unique en el campo link, si no la validaci??n del formulario parar?? la ejecuci??n.
A continuaci??n crea un m??todo static en el modelo que se llame hasAlreadyBeenSubmitted al que le pasaremos como argumento el link y en el que ejecutaremos la consulta:
protected static function hasAlreadyBeenSubmitted($link)
{
if ($existing = static::where('link', $link)->first()) {
$existing->touch();
$existing->save();
return true;
}
return false;
}
Para actualizar el timestamp almacenaremos en una variable el registro devuelto y llamamos al m??todo touch() y save().
Reescribe el c??digo en el controlador para implementar esta funcionalidad y que siga funcionando la anterior. Debes probar que un usuario verificado puede seguir enviando enlaces y si el enlace est?? repetido se actualiza el timestamp y se sube a la primera posici??n. Si un usuario no verificado sube un enlace duplicado el comportamiento ser?? como hasta ahora.

Ejercicio 2. FormRequest
Se pueden hacer las validaciones en el controlador, tal y como hemos hecho en el ejercicio anterior. Sin embargo, no es del todo recomendable porque a??adimos c??digo al controlador que a la larga puede ser dif??cil de mantener. Por eso vamos a utilizar otra clase espec??fica de Laravel para la gesti??n de las validaciones: FormRequest.

Crea con artisan una clase para la gesti??n de errores. La clase se crear?? en la carpeta app/http/requests.

artisan make:request CommynityLinkForm

??De qui??n hereda la clase CommynityLinkForm?

Copia las reglas de validaci??n del controlador en el m??todo rules().

El m??todo authorize de momento tiene que devolver true. M??s adelante, si trabajamos con autorizaciones, modificaremos el valor de este m??todo.

Inyecta la clase CommynityLinkForm en el m??todo store y cambia request()->merge por $request->merge.

Comprueba que todo sigue funcionando.

En el siguiente enlace tienes informaci??n sobre todas las validaciones que se pueden hacer con Laravel: https://laravel.com/docs/9.x/validation#available-validation-rules

Ejercicio 3. Partial para el listado de links

Por ??ltimo, para ordenar un poco el c??digo, crea un partial para la lista de links.

## A38. Filtrar canales
Ejercicio 1. Cambiar m??todo static

En el ejercicio anterior implementamos el m??todo hasAlreadyBeenSubmitted como un m??todo static para poder acceder directamente desde el modelo CommunityLink. No est?? mal hacerlo as?? y, de hecho, la ejecuci??n de m??todos static en PHP es m??s r??pida que los m??todos de instancia. Sin embargo, este tipo de m??todos dificultan la realizaci??n de testing de aplicaciones. Por eso vamos a reescribirlo como un m??todo de instancia. Es muy sencillo. S??lo tienes que crear un objeto de tipo CommunityLink:

$link = new CommunityLink();
$link->user_id = Auth::id();
Y llamar al m??todo desde el objeto:

$link->hasAlreadyBeenSubmitted($request->link)
Ejercicio 2. Filtrar canales

Seguimos a??adiendo funcionalidades al proyecto. Queremos que al pulsar en un canal se muestren s??lo los links de ese canal.

La idea es utilizar el slug para llamar a trav??s de una ruta al m??todo en el controlador. Por lo tanto, en la vista lista.blade.php (o como le hayas llamado) modifica el c??digo para que cada canal tenga un link formado por su slug:

<a href="/community/{{ $link->channel->slug }}"...
A continuaci??n a??ade la ruta en web.php:

Route::get('community/{channel}', [App\Http\Controllers\CommunityLinkController::class, 'index']);
De esta manera ser?? el m??todo index el encargado de hacer el filtrado dependiendo del par??metro channel. Otra opci??n podr??a haber sido crear un m??todo diferente para cada canal, pero es mucho m??s dif??cil de mantener a medida que aumenta el n??mero de canales.

Modifica el m??todo index para que le podamos pasar el channel como par??metro:

public function index(Channel $channel = null) {...}
Con??ctate mediante una URL, por ejemplo, community/php. Obtendr??s un error (compru??balo).

Incluye al principio del m??todo index lo siguiente:

dd($channel);
Con??ctate mediante una URL con id del canal, por ejemplo, commynity/1. ??Qu?? sucede? Esto es debido al Route Model Binding que utiliza Laravel. Consulta el siguiente enlace y explica en qu?? consiste: https://laravel.com/docs/9.x/routing#route-model-binding.

Tal y como se explica en la documentaci??n anterior, para poder utilizar el slug en lugar del id del canal en la ruta debemos incluir el siguiente m??todo en el modelo Channel:

public function getRouteKeyName()
{
return 'slug';
}
Comprueba ahora que s?? te puedes conectar a trav??s del slug.

Elimina el dd y modifica el m??todo index de tal manera que si se ha pasado el slug del canal por la URL filtre los links de ese canal. Si no hay slug en la URL se mostrar??n todos los canales.

Ejercicio 3. Mejorar la navegaci??n

Para mejorar la navegaci??n incluye en el texto Community de la vista un enlace al listado completo (/community).

Incluye tambi??n el title del canal al lado de Community

## A40. Sistema de votaci??n
Ejercicio 1. Reescribiendo el filtrado de canales

Con lo que hemos aprendido en la pr??ctica anterior podemos usar Eloquent y redefinir la consulta para filtrar canales, ya que existe una relaci??n 1:N entre canales y links. Por lo tanto, define la relaci??n hasMany en el modelo Channel:

public function communitylinks()
{
   return $this->hasMany(CommunityLink::class);
}
Y reescribe la consulta en el m??todo index del controlador. Comprueba que todo sigue funcionando.

Ejercicio 2. Tabla pivote

Queremos implementar un sistema de votaci??n de links, es decir, un usuario puede votar varios links y un link puede ser votado por varios usuarios. Esto va a dar lugar a una tabla N:M a la que se le llama tabla pivote y que tendr?? el user_id y el community_link_id.

La informaci??n que nos interesa sacar de esta relaci??n es, por un lado, todos los votos que tiene un link, para poder mostrarlos y, por otro, qu?? usuarios han votado a qu?? links. As??, evitaremos que un usuario vote dos veces el mismo link y podremos implementar que un usuario deshaga un voto.

En principio, no ser??a necesario crear un modelo para la tabla pivote, a no ser que se quiera a??adir funcionalidad. Nosotros s?? lo vamos a crear porque necesitaremos a??adir l??gica al modelo m??s adelante. Lo creamos con su migraci??n asociada:

artisan make:model CommunityLinkUser -m

Editamos la migraci??n:

Schema::create('community_links_users', function (Blueprint $table) {
$table->id();
$table->integer('user_id')->index();
$table->integer('community_link_id')->index();
$table->timestamps();
});
Hay que recordar que en el caso de haber usado sqlite se eliminan las restricciones de clave for??nea por defecto: https://laravel.com/docs/9.x/database#sqlite-configuration, pero podr??an incluirse, tal y como hiciste en la pr??ctica anterior.

Y ejecutamos la migraci??n con artisan migrate.

Ejercicio 3. Relaciones

Para implementar el sistema de votos una opci??n puede ser tener un campo num_votes en el modelo CommunityLink. Sin embargo, podemos obtener de la tabla pivote una colecci??n de todos los usuarios que han votado un link, as?? que haciendo un count de esa colecci??n tenemos el n??mero de votos. Esto simplifica la l??gica del programa porque cada vez que se vota no hay que acceder a dos tablas (community_links y la tabla pivote) y, adem??s, no hay que crear una nueva migraci??n para modificar la tabla community_llinks.

Creamos la relaci??n que nos permite obtener los usuarios que han votado a un link:

public function users()
{
return $this->belongsToMany(User::class, 'community_link_users');
}
Crea con tinker un registro con un user_id de un usuario trusted y con un community_link_id que est?? approved (recuerda hacer los campos fillable en el modelo). Por ejemplo:

CommunityLinkUser::create(['user_id'=>2,'community_link_id'=>239])

$link = CommunityLink::find(239)

Y comprueba que funciona ejecutando el m??todo:

$link->users()->get()

Haz que otro usuario vote por el mismo link y comprueba con tinker que est?? funcionando.

Es el momento de modificar la vista para que se muestre el n??mero de votos para cada link:

{{$link->users()->count()}} 

## A41. Sistema de votaci??n (II)
Ejercicio 1. Formulario para votar

Para que un usuario pueda votar vamos a crear un formulario en la vista list.blade.php:

<form method="POST" action="/votes/{{ $link->id }}">
{{ csrf_field() }}
<button type="button" class="btn btn-secondary" {{ Auth::guest() ? 'disabled' : '' }}>
{{$link->users()->count()}}
</button>
</form>
Si el usuario no est?? autenticado el bot??n no se podr?? pulsar (disabled). Comprueba el funcionamiento.

F??jate que cuando un usuario vota tenemos que pasar a la tabla pivote el user_id (que ya tenemos con Auth::id()) y el community_link_id, que le pasamos por post en el formulario. Esta funcionalidad la programaremos en la siguiente pr??ctica.

Ejercicio 2. M??todo votedFor

Nos interesa, adem??s, que si un usuario ya ha votado por un link, el color del bot??n que se le muestre sea distinto. Para ello necesitamos saber qu?? links ha votado un usuario. Lo hacemos definiendo la relaci??n belongsToMany con Elquent en el modelo User. Crea un m??todo que se llame votes() con esta relaci??n y a??ade el modificador ->withTimestamps(), para indicar que se incluyen los tiempos de creaci??n y actualizaci??n de un registro.

Implementa en el modelo User un m??todo votedFor, al que le pasaremos el link que se est?? intentando votar y devolver?? true o false si el link ya se ha votado:

public function votedFor(CommunityLink $link)
{
return $this->votes->contains($link);
}
Por ??ltimo, en la vista usamos el m??todo de la siguiente manera en el atributo class del bot??n:

{{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}"
F??jate que una vez que tenemos los links que ha votado un usuario comprobamos si ese link concreto cumple la condici??n.

Comprueba que todo funciona.

Ejercicio 3. Votar un link

Crea la ruta para votar un link (mira el action del formulario). Llamaremos al m??todo store del controlador CommunityLinkUserController y utilizaremos implicit model binding a partir del id del link.

Crea el controlador con artisan y crea un m??todo store al que le pasaremos como argumento un CommunityLink:

public function store(CommunityLink $link)
{
$vote = CommunityLinkUser::firstOrNew(['user_id' => Auth::id(),'community_link_id' => $link->id]);
if ($vote->id) {
$vote->delete();
} else {
$vote->save();
}
     return back();
}
??Explica l??nea a l??nea qu?? hace este m??todo?

Comprueba que todo funciona conect??ndote con distintos usuarios y votando y retirando el voto a alg??n link.

Lo que hemos hecho est?? bien pero podemos refactorizar el c??digo y meter la l??gica del m??todo store en un m??todo toggle():

CommunityLinkUser::firstOrNew([
'user_id' => Auth::id(),
'community_link_id' => $link->id
])->toggle();
Implementa el m??todo toggle

## A42. Ordenar por popularidad
Ejercicio 1. El m??s votado

Queremos a??adir la funcionalidad de ordenar los links por popularidad, es decir, los m??s votados primero. Lo implementaremos en el m??todo index de CommunityLink mediante una nueva consulta. Para ello, pararemos por la URL la palabra "popular" (community.local/community?popular) y en el m??todo index controlaremos si existe esta palabra en la URL a la hora de mostrar los resultados:

if (request()->exists('popular')) {...}
Podr??amos hacerlo con una ruta community/popular que llamara a index, pero as?? vemos una forma diferente de hacerlo.

Para hacer el recuento de votos y ordenar descendentemente utilizaremos la potencialidad de Eloquent. En concreto, usaremos el m??todo withCount y orderBy. Consulta este enlace https://stackoverflow.com/questions/39709729/laravel-count-eloquent-belongstomany-related-model para ver c??mo funciona este m??todo e implementa la consulta en el m??todo index. Todo debe seguir funcionando como hasta ahora.

Un problema con el que te vas a encontrar es que cuando pulses en cualquier p??gina del sistema de paginaci??n de Laravel ya no estar??s filtrando por popularidad. Para resolver este problema usa la funci??n appends de la siguiente manera:

{{ $links->appends($_GET)->links() }}
Ejercicio 2. CommunityLinksQuery

Te habr??s fijado en que a medida que las funcionalidades de la aplicaci??n crecen las consultas se complican y los m??todos de los controladores ir??n creciendo en tama??o. Por eso vamos a crear una clase CommunityLinksQuery que encapsular?? todas las consultas que necesitemos en el controlador.

Crea una carpeta Queries en app y dentro crea la clase CommunityLinksQuery en el namespace App\Queries:

<?php

namespace App\Queries;

class CommunityLinksQuery
{
public function getByChannel(Channel $channel)
{
# code...
}

public function getAll()
{
# code...
}

public function getMostPopular()
{
# code...
}
}
Implementa los tres m??todos y comprueba que todo sigue funcionando.

Ejercicio 3. El m??s reciente o el m??s popular

A??ade dos tab de bootstrap en la vista list.blade.php:

<ul class="nav">
<li class="nav-item">
<a class="nav-link {{request()->exists('popular') ? '' : 'disabled' }}" href="{{request()->url()}}">Most recent</a>
</li>
<li class="nav-item">
<a class="nav-link {{request()->exists('popular') ? 'disabled' : '' }}" href="?popular">Most popular</a>
</li>
</ul>
Prueba el c??digo y explica detalladamente qu?? hace.

Cuando filtramos por canal, el filtro m??s popular no funciona. Piensa c??omo resolverlo e implem??ntalo.

## A43. B??squeda de registros
Ejercicio 1. Fontawsome o BootStrap Icons

Incluye fontawsome o BootStrap Icons en tu proyecto (por CDN o instal??ndolo en Laravel, como prefieras).

A??ade un icono de like al lado de cada enlace en la lista de links.

Ejercicio 2. B??squeda por formulario

En este ejercicio vamos a incluir en nuestra barra de navegaci??n un formulario para la b??squeda sencilla de registros.



Modifica el partial de la barra de navegaci??n para que incluya el formulario de b??squeda:

El formulario se enviar?? por GET.
El action ser?? la ruta que llame al m??todo index del controlador CommunityLink.
El formulario debe tener persistencia de datos.
En el m??todo index a??ade la l??gica para poder hacer la b??squeda. Ten en cuenta lo siguiente:

Para saber si un usuario ha hecho una b??squeda puedes usar el m??todo request() igual que hiciste con ?popular.
Debes hacer un trimado del texto a buscar antes de hacer la consulta. Puedes usar la funci??n trim y el m??todo get() de request().
Crea una consulta Eloquent en CommunityLinksQuery que devuelva los links que coincidan con el texto a buscar. Usa el operador like en la cl??usula where.
Comprueba que la nueva caracter??stica funciona y que, adem??s, el resto de funcionalidades siguen funcionando como hasta ahora.

Ejercicio 3. B??squeda por dos palabras

Tal y como est?? hecha la consulta para la b??squeda de links s??lo se pueden localizar registros por una palabra clave. Piensa como podr??as hacer una consulta que funcione con dos palabras separadas por un espacio e implem??ntala.

Ejercicio 4. Most popular

F??jate que el filtrado por Most Popular no funcionar?? sobre los registros resultantes de la b??squeda. Implementa esta funci??n