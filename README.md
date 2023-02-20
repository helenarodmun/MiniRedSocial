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

##  A31. Tablas del proyecto y sistema de autenticación

Como proyecto vamos a crear una mini red social en la que sus usuarios podrán compartir enlaces de interés (una especie de Reddit o Menéame pero simplificada). Estos recursos se podrán votar y estarán asociados a un canal o temática concreta. Por lo tanto, la idea general de la funcionalidad es que un usuario pueda publicar un link vinculado a un canal.
Ejercicio 1. Tablas

Documentación sobre migraciones: https://laravel.com/docs/9.x/migrations

Laravel utiliza las migraciones para poder definir y crear las tablas de la base de datos desde código, y de esta manera tener un control de versiones de las mismas. Es muy cómodo, sobre todo cuando varios desarrolladores trabajan sobre una BBDD local que puede cambiar. Así siempre trabajan todos con la misma base de datos.

Nuestro proyecto tendrá tres tablas: community_links, channels y users.

ejecuta artisan para crear una migración para la tabla community_links:

artisan make:migration create_community_links_table

Si todo va bien podremos ver la migración en la carpeta de migraciones. En el método create de la función up de la migración incluye los siguientes campos:

$table->id();
$table->integer('user_id')->index();
$table->integer('channel_id')->index();
$table->string('title');
$table->string('link')->unique();
$table->boolean('approved')->default(0);
$table->timestamps();

Fíjate que se ha creado el método up y down. En el método down de la migración se deshacen los cambios que se han hecho en el método up. En este caso sería eliminar la tabla y ya viene codificado por defecto.

Facade: https://www.laraveltip.com/para-que-sirven-las-facades-en-laravel-explicadas-con-un-caso-real/

Creamos ahora la tabla channels:

artisan make:migration create_channels_table --create=channels

Y añadimos sus campos:

$table->id();
$table->string('title');
$table->string('slug')->unique();
$table->string('color');
$table->timestamps();
Si ejecutamos artisan migrate probablemente no funcionará porque la BBDD está sin configurar.

Si estás usando Laragon usa mysql. En caso contrario puedes usar sqlite. Es rápida de configurar y cómoda de usar pero no sirve para un proyecto mediano o que requiera integridad referencial. En el .env debes borrar toda la información relativa a mysql y dejar la siguiente línea:

DB_CONNECTION=sqlite
Creamos el fichero de la BBDD:

touch database/database.sqlite

Y ejecutamos las migraciones con el comando artisan migrate.

Comprueba con el cli de sqlite que la tabla se ha creado correctamente: sqlite3 database/database.sqlite o con la interface de Laragon.

Ejercicio 2. Sistema de autenticación

Vamos a necesitar usuarios registrados en nuestra aplicación así que vamos a instalar Breeze, uno de los sistemas de autenticación que trae incorporado Laravel. Breeze usa Tailwind como framework CSS, lo cual no impide que puedas usar Bootstrap en otras partes de tu proyecto.

Existe ya una migración con el nombre create_users_table para la tabla users con todos los campos necesarios que crea Laravel por nosotros. Ejecútala con artisan migrate.

Al instalar Breeze se generará un "scaffolding", es decir, una estructura básica que consiste en una serie de rutas y vistas predefinidas para el sistema de autenticación. Para instalarlo teclea lo siguiente:

composer require laravel/breeze --dev (instalará el paquete)

php artisan breeze:install blade (blade es el motor de plantillas HTML por defecto de Laravel)

npm run dev

Comprueba que se han generado varias vistas en resources/views/auth.
Laravel trae incorporados varios controladores para las funciones de autenticación. Están localizados en App\Http\Controllers\Auth. Para la mayor parte de aplicaciones no será necesario modificar estos controladores. Identifica para qué sirve cada uno.
Ejecuta también el comando artisan route:list para ver las rutas que se han creado asociadas a estos controladores.
Comprueba que en el archivo de rutas web.php hay un include con las rutas para la autenticación. Abre el archivo que contiene las rutas para la autenticación, escoge alguna y explícala con tus palabras.
Ejercicio 3. Confirmar e-mail y recuperar password

Para implementar la confirmación por correo cuando un usuario se registra vamos a usar mailtrap, que es un servidor de correo de prueba que evita tener que introducir direcciones de correo reales. Regístrate en mailtrap y copia la configuración para Laravel que deberás incluir en tu fichero .env. Ahora cualquier correo que envíe Laravel se hará a través de mailtrap.

En el modelo User indicamos que implementamos el interface MustVerifyEmail:

class User extends Authenticatable implements MustVerifyEmail
Por último, en el fichero web.php habilitamos el middleware para la verificación de las rutas. En nuestro caso sólo podremos acceder al dashboard si hemos verificado el correo-e:

Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

## A32. Primeras rutas, factories y relaciones entre tablas

Ejercicio 1. Primeras rutas

Vamos a crear las primeras rutas, controladores y vistas de la aplicación que nos permitirán ver todo el flujo MVC en Laravel. En otra práctica profundizaremos un poco más en el sistema de rutas de Laravel.

El fichero donde se definen las rutas se llama web.php, dentro de la carpeta routes. Hay, además, un fichero api.php específico para las rutas de la API de nuestra app. Ejecuta artisan route:list para ver las rutas que ya tienes definidas. Verás las rutas del sistema de autenticación, entre otras.

De momento vamos a crear dos rutas para nuestro proyecto, una para mostrar todos los enlaces que llamará al método index mediante GET y otra para crear un link que llamará al método store del controlador mediante POST:

Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);
Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store']);
El controlador CommunityLinkController no existe, así que créalo con su modelo asociado mediante artisan make:controller CommunityLinkController --model=CommunityLink.

El método index del controlador devolverá una vista index.blade.php:

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
Y en el fichero navigation.blade.php tienes que poner la directiva blade @auth y al final del mismo @endauth. Esto lo hacemos ya que la barra de navegación sólo la vamos a mostrar a los usuarios logueados.

En el fichero RouteServiceProvider de la carpeta app/providers cambia el valor de HOME a /community.

Ejercicio 2. Factories

Laravel permite generar datos de prueba para las tablas de manera automática mediante factories y seeders: https://laravel.com/docs/9.x/database-testing#defining-model-factories.

Para el modelo User los factories ya están configurados, así que basta con abrir tinker (el REPL de Laravel), tecleando artisan tinker, y escribir lo siguiente para crear cinco usuarios de prueba:

User::factory()->count(5)->create()

Si tecleas User::all() verás los usuarios que se han creado (estás usando Eloquent, el ORM de Laravel, al hacer User::all())

Para el modelo CommunityLink tenemos que crear nosotros un factory con artisan make:factory CommunityLinkFactory --model=CommunityLink.

Para que los campos se puedan rellenar automáticamente deben declararse como fillable en el modelo:

protected $fillable = [
  'user_id', 'channel_id', 'title', 'link', 'approved'
];
Además, debemos añadir los campos que queremos que se rellenen automáticamente en el método definition de la clase CommunityLinkFactory:

return [
 'user_id' => \App\Models\User::all()->random()->id,
 'channel_id' => 1,
 'title' => $this->faker->sentence,
 'link' => $this->faker->url,
 'approved' => 0
];
La clase Faker tiene infinidad de tipos de datos: https://github.com/fzaninotto/Faker

Añade en el método run de la clase DatabaseSeeder la llamada al factory (resuelve las dependencias con use):

DB::delete('delete from community_links');
CommunityLink::factory()->count(50)->create(); 
Por último, ejecuta artisan db:seed para generar los datos.

La clase DB es el QueryBuilder de Laravel: https://laravel.com/docs/9.x/queries

Ejercicio 3. Paginar resultados

Documentación sobre paginación: https://laravel.com/docs/9.x/pagination

Paginar resultados es muy sencillo en Laravel. Modifica el método index del controlador:

public function index() {
  $links = CommunityLink::paginate(25);
  return view('community/index', compact('links'));
}
Y añade en el index.blade, en la sección content, lo siguiente:

@foreach ($links as $link)
<li>{{$link->title}}</li>
@endforeach
{{$links->links()}}
Ejercicio 4. Relaciones entre tablas

Documentación sobre cómo relacionar tablas en Eloquent: https://laravel.com/docs/9.x/eloquent-relationships.

 De momento, nos interesa mostrar junto con el link el nombre del autor y la fecha. Para ello vamos a relacionar las tablas. En el modelo CommunityLink crea el siguiente método:

public function creator()
{
  return $this->belongsTo(User::class, 'user_id');
}
Y en la vista index.blade.php añade lo siguiente para cada link:

<small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>

## A34. Formulario para añadir un link
Ejercicio 1. Proteger rutas

Comprueba si todas las rutas que hacen referencia a los controladores que has creado están protegidas por contraseña. Puedes verlo mediante el comando artisan route:list -v  en la columna Middleware.

Comprueba que puedes acceder a alguna ruta no protegida sin introducir credenciales. Para evitar esto aplica el middleware auth a las rutas desprotegidas del controlador CommunityLinkController (->middleware('auth'))

Comprueba que ahora no tienes acceso a estas rutas sin haberte logueado.

Ejercicio 2. Añadir un link

A pesar de que Breeze utiliza Tailwind nosotros vamos a trabajar con Bootstrap. Inclúyelo por CDN en la vista:

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
 
Comprueba que ves la vista con los estilos de Bootstrap.

A la hora de subir un link a la BBDD tenemos que incluir el user_id y el channel_id, ya que están en la tabla community_link. Sin embargo, no están en el formulario. Lo haremos de la siguiente manera en el método store:

public function store(Request $request) {
  request()->merge(['user_id' => Auth::id(), 'channel_id' => 1 ]);
  CommunityLink::create($request->all());
  return back();
}
El método merge del objeto request (request()->merge) nos permite unir a la solicitud HTTP parámetros que no están inicialmente en la misma. Esto, por un lado, evita tener que pasar el user_id por un campo hidden del formulario (lo cual es poco deseable) o en la URL. El channel_id, de momento lo vamos a hardcodear, para simplificar.

Ejercicio 3. Objeto requets

Documentación sobre el objeto Request en Laravel: https://laravel.com/docs/9.x/requests

En el método store haz un dd($request) al principio del mismo. ¿Qué hay en parameters? ¿Qué obtiene el método all()?

Dentro del método store prueba los siguientes métodos y explica qué hacen:

$request->path();
$request->url();
$request->input()
$request->fullUrl();
Ejercicio 4. Objeto response

Documentación sobre el objeto Response en Laravel: https://laravel.com/docs/9.x/responses

Utiliza el helper response para devolver una cadena 'Respuesta' con código 200. (return response('Respuesta', 200). Comprueba el código HTTP con el inspector de código del navegador, en la pestaña network (recarga la página si es necesario).

Prueba ahora a enviar la cadena "Error" y el código 404. Comprueba el código con el inspector de código.

Ejercicio 5. Validación

Documentación sobre validación en Laravel: https://laravel.com/docs/9.x/validation

Laravel tiene un sistema de valicación muy sencillo. La clase Controller, de la cual hereda nuestro controlador CommunityController, usa la clase ValidatesRequests, lo cual significa que podemos usar todo el sistema de validación de Laravel directamente en nuestro controlador. Incluye en el método store lo siguiente:

$this->validate($request, [
  'title' => 'required',
  'link' => 'required|active_url'
]);
La gestión de errores en las vistas con Laravel también es muy sencilla. De hecho, podemos mostrar los errores en las vistas a través de la variable $errors. Existe también la posibilidad de utilizar la directiva @errors de blade para mostrar los errores. Consulta el siguiente enlace y haz que se muestren los errores en el formulario: https://laravel.com/docs/9.x/blade#validation-errors

Ejercicio 6. Partial

Nos interesa poner el formulario para añadir un link en un partial, para que la vista quede más clara. Por lo tanto, en la vista anterior crea un partial add-link.blade.php utilizando la directiva @include de blade.

## A35. Channels y persistencia de datos
Ejercicio 1. Añadir canales

Ya tenemos creados los modelos para los usuarios y para los enlaces. Nos falta el modelo para los canales y añadir al formulario un desplegable para poder asociar un link a un canal o temática concreta.

Crea el modelo Channel con artisan.

Intenta insertar un registro con tinker. Te dará un error, ya que los atributos del modelo tienen que ser fillable. Corrígelo (recuerda cómo lo hiciste con el modelo CommunityLink).

Modifica el método store del controlador CommunityLinkController para que se valide el channel:

'channel_id' => 'required|exists:channels,id'
Añade lo siguiente al método index para pasarle a la vista todos los canales y poder mostrarlos ordenados en el formulario:

$channels = Channel::orderBy('title','asc')->get();
Añade a la vista add-link.blade.php el siguiente código para añadir el desplegable al formulario:

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
Comprueba que puedes añadir un enlace y comprueba con Tinker que se creal el channel_id correspondiente (recuerda que lo teníamos hardcodeado).

Ejercicio 2. Persistencia de datos

La persistencia de datos se consigue con el helper old. No puede ser más sencillo. Por ejemplo, para el campo title pondríamos en el atributo value el valor old('title'):

value="{{old('title')}}"
Para el desplegable es un poco diferente y deberemos incluir lo siguiente en el atributo value de la etiqueta option:

<option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>

Intenta dar de alta un link con la misma URL. ¿Qué sucede?

Para resolverlo añade en el controlador la siguiente validación al link para que no salte el error:

'link' => 'required|active_url|unique:community_links'
Ejercicio 3. Relación entre channel y link

Para poder mostrar el canal al que pertenece un link en la lista tenemos que relacionar los modelos CommunityLink y Channel. Es una relación 1:N. Impleméntala igual que hicimos con CommunityLink y User.

Ahora en la lista de links ya podemos añadir el canal, por ejemplo, mediante una etiqueta span dentro de cada <li>:

<span class="label label-default" style="background: {{ $link->channel->color }}">
{{ $link->channel->title }}
</span>

## A36. Aprobar un link, usuarios verificados y flash messages
Nuestra aplicación, tal y como está implementada, permite que se suba un link automáticamente, sin necesidad de ser aprobado por el administrador. Esto no es lo que queremos.

Además, queremos que cuando un usuario sube, por ejemplo, tres links se convierta en usuario verificado y que no sea necesario que el administrador apruebe los links que suba a partir de ese momento.

Ejercicio 1. Mostrar sólo los links aprobados

La primera funcionalidad es sencilla. Recuerda que nuestro modelo tiene un campo approved que, por defecto, es 0. Simplemente filtramos la consulta en el método index para mostrar sólo los links que estén aprobados:

$links = CommunityLink::where('approved', 1)->paginate(25);

Utiliza @if en la vista blade para que si no hay ningún link aprobado (count($links)) muestre "No contributions yet".

Ejercicio 2. Usuarios verificados

Para poder implementar esta funcionalidad vamos a añadir a User un campo trusted que indicará si un usuario es verificado (se le han aprobado más de tres links) o no.

Podríamos añadir el campo a la migración ya existente y hacer un reset o refresh de las migraciones, pero al realizar una modificación en la migración original tenemos el problema de que se eliminará el contenido de las tablas en la base de datos. Si estamos en modo desarrollo nos da igual. Es más, se aconseja hacerlo así para que el número de migraciones no aumente innecesariamente. Sin embargo, lo vamos a hacer como si la aplicación estuviera en producción para aprender cómo sería. Por lo tanto, creamos  una nueva migración y agregamos desde ahí las modificaciones que necesitamos:

artisan make:migration add_trusted_to_users

Añadimos la columna en el método up:

$table->boolean('trusted')->default(0);
Fíjate que usamos el método table de la facade Schema, en lugar de create, como hasta ahora.

En el método down() especificamos la acción inversa por si necesitamos hacer un rollback:

$table->dropColumn('trusted');
Ejecuta la migración con artisan migrate y comprueba con Tinker que se ha creado la nueva columna.

Modificamos el método store para hacer las comprobaciones oportunas:

$approved = Auth::user()->trusted ? true : false;
request()->merge(['user_id' => Auth::id(), 'approved'=>$approved]);
Comprueba que un usuario no verificado no puede publicar directamente.

Con tinker convierte un usuario en verificado ($u->User::first();$u->trusted=true;$u->save()) y comprueba que los links que envía se aprueban automáticamente.

Para mejorar un poco la encapsulación crea un método isTrusted en el User que devuelva el atributo trusted, en lugar de acceder directamente al campo trusted de User.

Ejercicio 3. Mensajes flash

No le estamos dando feedback al usuario cuando crea un link, tanto si este se ha aprobado como si no. Vamos a implementarlo con mensajes flash. Consulta el siguiente tutorial para hacerlo: https://www.itsolutionstuff.com/post/laravel-8-flash-message-tutorial-exampleexample.html.

Comprueba que se muestan los mensajes correspondientes tanto para un usuario verificado como para uno no verificado.

Antes de continuar con la siguiente práctica crea tu propio archivo css en la carpeta public y dale estilo a la página

## A37. Timestamps y validación mediante FormRequest
Ejercicio 1. Timestamps
Nos interesa ampliar la funcionalidad de la app, de tal manera que si un usuario envía un link que ya existe se debe actualiza el timestamp y, por lo tanto, ese link aparecerá el primero en la lista. Además, se informará mediante un flash de lo que ha sucedido. El campo título y el campo autor no se actualizarán.
Antes de nada lo que tenemos que hacer es ordenar la consulta para que aparezcan los últimos registros primero:
$links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
El método latest ordena por última fecha de creación, no de actualización. Por eso le hemos pasado el argumento updated_at.
Lo siguiente que tenemos que hacer es quitar la validación unique en el campo link, si no la validación del formulario parará la ejecución.
A continuación crea un método static en el modelo que se llame hasAlreadyBeenSubmitted al que le pasaremos como argumento el link y en el que ejecutaremos la consulta:
protected static function hasAlreadyBeenSubmitted($link)
{
if ($existing = static::where('link', $link)->first()) {
$existing->touch();
$existing->save();
return true;
}
return false;
}
Para actualizar el timestamp almacenaremos en una variable el registro devuelto y llamamos al método touch() y save().
Reescribe el código en el controlador para implementar esta funcionalidad y que siga funcionando la anterior. Debes probar que un usuario verificado puede seguir enviando enlaces y si el enlace está repetido se actualiza el timestamp y se sube a la primera posición. Si un usuario no verificado sube un enlace duplicado el comportamiento será como hasta ahora.

Ejercicio 2. FormRequest
Se pueden hacer las validaciones en el controlador, tal y como hemos hecho en el ejercicio anterior. Sin embargo, no es del todo recomendable porque añadimos código al controlador que a la larga puede ser difícil de mantener. Por eso vamos a utilizar otra clase específica de Laravel para la gestión de las validaciones: FormRequest.

Crea con artisan una clase para la gestión de errores. La clase se creará en la carpeta app/http/requests.

artisan make:request CommynityLinkForm

¿De quién hereda la clase CommynityLinkForm?

Copia las reglas de validación del controlador en el método rules().

El método authorize de momento tiene que devolver true. Más adelante, si trabajamos con autorizaciones, modificaremos el valor de este método.

Inyecta la clase CommynityLinkForm en el método store y cambia request()->merge por $request->merge.

Comprueba que todo sigue funcionando.

En el siguiente enlace tienes información sobre todas las validaciones que se pueden hacer con Laravel: https://laravel.com/docs/9.x/validation#available-validation-rules

Ejercicio 3. Partial para el listado de links

Por último, para ordenar un poco el código, crea un partial para la lista de links.

## A38. Filtrar canales
Ejercicio 1. Cambiar método static

En el ejercicio anterior implementamos el método hasAlreadyBeenSubmitted como un método static para poder acceder directamente desde el modelo CommunityLink. No está mal hacerlo así y, de hecho, la ejecución de métodos static en PHP es más rápida que los métodos de instancia. Sin embargo, este tipo de métodos dificultan la realización de testing de aplicaciones. Por eso vamos a reescribirlo como un método de instancia. Es muy sencillo. Sólo tienes que crear un objeto de tipo CommunityLink:

$link = new CommunityLink();
$link->user_id = Auth::id();
Y llamar al método desde el objeto:

$link->hasAlreadyBeenSubmitted($request->link)
Ejercicio 2. Filtrar canales

Seguimos añadiendo funcionalidades al proyecto. Queremos que al pulsar en un canal se muestren sólo los links de ese canal.

La idea es utilizar el slug para llamar a través de una ruta al método en el controlador. Por lo tanto, en la vista lista.blade.php (o como le hayas llamado) modifica el código para que cada canal tenga un link formado por su slug:

<a href="/community/{{ $link->channel->slug }}"...
A continuación añade la ruta en web.php:

Route::get('community/{channel}', [App\Http\Controllers\CommunityLinkController::class, 'index']);
De esta manera será el método index el encargado de hacer el filtrado dependiendo del parámetro channel. Otra opción podría haber sido crear un método diferente para cada canal, pero es mucho más difícil de mantener a medida que aumenta el número de canales.

Modifica el método index para que le podamos pasar el channel como parámetro:

public function index(Channel $channel = null) {...}
Conéctate mediante una URL, por ejemplo, community/php. Obtendrás un error (compruébalo).

Incluye al principio del método index lo siguiente:

dd($channel);
Conéctate mediante una URL con id del canal, por ejemplo, commynity/1. ¿Qué sucede? Esto es debido al Route Model Binding que utiliza Laravel. Consulta el siguiente enlace y explica en qué consiste: https://laravel.com/docs/9.x/routing#route-model-binding.

Tal y como se explica en la documentación anterior, para poder utilizar el slug en lugar del id del canal en la ruta debemos incluir el siguiente método en el modelo Channel:

public function getRouteKeyName()
{
return 'slug';
}
Comprueba ahora que sí te puedes conectar a través del slug.

Elimina el dd y modifica el método index de tal manera que si se ha pasado el slug del canal por la URL filtre los links de ese canal. Si no hay slug en la URL se mostrarán todos los canales.

Ejercicio 3. Mejorar la navegación

Para mejorar la navegación incluye en el texto Community de la vista un enlace al listado completo (/community).

Incluye también el title del canal al lado de Community

## A40. Sistema de votación
Ejercicio 1. Reescribiendo el filtrado de canales

Con lo que hemos aprendido en la práctica anterior podemos usar Eloquent y redefinir la consulta para filtrar canales, ya que existe una relación 1:N entre canales y links. Por lo tanto, define la relación hasMany en el modelo Channel:

public function communitylinks()
{
   return $this->hasMany(CommunityLink::class);
}
Y reescribe la consulta en el método index del controlador. Comprueba que todo sigue funcionando.

Ejercicio 2. Tabla pivote

Queremos implementar un sistema de votación de links, es decir, un usuario puede votar varios links y un link puede ser votado por varios usuarios. Esto va a dar lugar a una tabla N:M a la que se le llama tabla pivote y que tendrá el user_id y el community_link_id.

La información que nos interesa sacar de esta relación es, por un lado, todos los votos que tiene un link, para poder mostrarlos y, por otro, qué usuarios han votado a qué links. Así, evitaremos que un usuario vote dos veces el mismo link y podremos implementar que un usuario deshaga un voto.

En principio, no sería necesario crear un modelo para la tabla pivote, a no ser que se quiera añadir funcionalidad. Nosotros sí lo vamos a crear porque necesitaremos añadir lógica al modelo más adelante. Lo creamos con su migración asociada:

artisan make:model CommunityLinkUser -m

Editamos la migración:

Schema::create('community_links_users', function (Blueprint $table) {
$table->id();
$table->integer('user_id')->index();
$table->integer('community_link_id')->index();
$table->timestamps();
});
Hay que recordar que en el caso de haber usado sqlite se eliminan las restricciones de clave foránea por defecto: https://laravel.com/docs/9.x/database#sqlite-configuration, pero podrían incluirse, tal y como hiciste en la práctica anterior.

Y ejecutamos la migración con artisan migrate.

Ejercicio 3. Relaciones

Para implementar el sistema de votos una opción puede ser tener un campo num_votes en el modelo CommunityLink. Sin embargo, podemos obtener de la tabla pivote una colección de todos los usuarios que han votado un link, así que haciendo un count de esa colección tenemos el número de votos. Esto simplifica la lógica del programa porque cada vez que se vota no hay que acceder a dos tablas (community_links y la tabla pivote) y, además, no hay que crear una nueva migración para modificar la tabla community_llinks.

Creamos la relación que nos permite obtener los usuarios que han votado a un link:

public function users()
{
return $this->belongsToMany(User::class, 'community_link_users');
}
Crea con tinker un registro con un user_id de un usuario trusted y con un community_link_id que esté approved (recuerda hacer los campos fillable en el modelo). Por ejemplo:

CommunityLinkUser::create(['user_id'=>2,'community_link_id'=>239])

$link = CommunityLink::find(239)

Y comprueba que funciona ejecutando el método:

$link->users()->get()

Haz que otro usuario vote por el mismo link y comprueba con tinker que está funcionando.

Es el momento de modificar la vista para que se muestre el número de votos para cada link:

{{$link->users()->count()}} 

## A41. Sistema de votación (II)
Ejercicio 1. Formulario para votar

Para que un usuario pueda votar vamos a crear un formulario en la vista list.blade.php:

<form method="POST" action="/votes/{{ $link->id }}">
{{ csrf_field() }}
<button type="button" class="btn btn-secondary" {{ Auth::guest() ? 'disabled' : '' }}>
{{$link->users()->count()}}
</button>
</form>
Si el usuario no está autenticado el botón no se podrá pulsar (disabled). Comprueba el funcionamiento.

Fíjate que cuando un usuario vota tenemos que pasar a la tabla pivote el user_id (que ya tenemos con Auth::id()) y el community_link_id, que le pasamos por post en el formulario. Esta funcionalidad la programaremos en la siguiente práctica.

Ejercicio 2. Método votedFor

Nos interesa, además, que si un usuario ya ha votado por un link, el color del botón que se le muestre sea distinto. Para ello necesitamos saber qué links ha votado un usuario. Lo hacemos definiendo la relación belongsToMany con Elquent en el modelo User. Crea un método que se llame votes() con esta relación y añade el modificador ->withTimestamps(), para indicar que se incluyen los tiempos de creación y actualización de un registro.

Implementa en el modelo User un método votedFor, al que le pasaremos el link que se está intentando votar y devolverá true o false si el link ya se ha votado:

public function votedFor(CommunityLink $link)
{
return $this->votes->contains($link);
}
Por último, en la vista usamos el método de la siguiente manera en el atributo class del botón:

{{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}"
Fíjate que una vez que tenemos los links que ha votado un usuario comprobamos si ese link concreto cumple la condición.

Comprueba que todo funciona.

Ejercicio 3. Votar un link

Crea la ruta para votar un link (mira el action del formulario). Llamaremos al método store del controlador CommunityLinkUserController y utilizaremos implicit model binding a partir del id del link.

Crea el controlador con artisan y crea un método store al que le pasaremos como argumento un CommunityLink:

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
¿Explica línea a línea qué hace este método?

Comprueba que todo funciona conectándote con distintos usuarios y votando y retirando el voto a algún link.

Lo que hemos hecho está bien pero podemos refactorizar el código y meter la lógica del método store en un método toggle():

CommunityLinkUser::firstOrNew([
'user_id' => Auth::id(),
'community_link_id' => $link->id
])->toggle();
Implementa el método toggle

## A42. Ordenar por popularidad
Ejercicio 1. El más votado

Queremos añadir la funcionalidad de ordenar los links por popularidad, es decir, los más votados primero. Lo implementaremos en el método index de CommunityLink mediante una nueva consulta. Para ello, pararemos por la URL la palabra "popular" (community.local/community?popular) y en el método index controlaremos si existe esta palabra en la URL a la hora de mostrar los resultados:

if (request()->exists('popular')) {...}
Podríamos hacerlo con una ruta community/popular que llamara a index, pero así vemos una forma diferente de hacerlo.

Para hacer el recuento de votos y ordenar descendentemente utilizaremos la potencialidad de Eloquent. En concreto, usaremos el método withCount y orderBy. Consulta este enlace https://stackoverflow.com/questions/39709729/laravel-count-eloquent-belongstomany-related-model para ver cómo funciona este método e implementa la consulta en el método index. Todo debe seguir funcionando como hasta ahora.

Un problema con el que te vas a encontrar es que cuando pulses en cualquier página del sistema de paginación de Laravel ya no estarás filtrando por popularidad. Para resolver este problema usa la función appends de la siguiente manera:

{{ $links->appends($_GET)->links() }}
Ejercicio 2. CommunityLinksQuery

Te habrás fijado en que a medida que las funcionalidades de la aplicación crecen las consultas se complican y los métodos de los controladores irán creciendo en tamaño. Por eso vamos a crear una clase CommunityLinksQuery que encapsulará todas las consultas que necesitemos en el controlador.

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
Implementa los tres métodos y comprueba que todo sigue funcionando.

Ejercicio 3. El más reciente o el más popular

Añade dos tab de bootstrap en la vista list.blade.php:

<ul class="nav">
<li class="nav-item">
<a class="nav-link {{request()->exists('popular') ? '' : 'disabled' }}" href="{{request()->url()}}">Most recent</a>
</li>
<li class="nav-item">
<a class="nav-link {{request()->exists('popular') ? 'disabled' : '' }}" href="?popular">Most popular</a>
</li>
</ul>
Prueba el código y explica detalladamente qué hace.

Cuando filtramos por canal, el filtro más popular no funciona. Piensa cñomo resolverlo e impleméntalo.

## A43. Búsqueda de registros
Ejercicio 1. Fontawsome o BootStrap Icons

Incluye fontawsome o BootStrap Icons en tu proyecto (por CDN o instalándolo en Laravel, como prefieras).

Añade un icono de like al lado de cada enlace en la lista de links.

Ejercicio 2. Búsqueda por formulario

En este ejercicio vamos a incluir en nuestra barra de navegación un formulario para la búsqueda sencilla de registros.



Modifica el partial de la barra de navegación para que incluya el formulario de búsqueda:

El formulario se enviará por GET.
El action será la ruta que llame al método index del controlador CommunityLink.
El formulario debe tener persistencia de datos.
En el método index añade la lógica para poder hacer la búsqueda. Ten en cuenta lo siguiente:

Para saber si un usuario ha hecho una búsqueda puedes usar el método request() igual que hiciste con ?popular.
Debes hacer un trimado del texto a buscar antes de hacer la consulta. Puedes usar la función trim y el método get() de request().
Crea una consulta Eloquent en CommunityLinksQuery que devuelva los links que coincidan con el texto a buscar. Usa el operador like en la cláusula where.
Comprueba que la nueva característica funciona y que, además, el resto de funcionalidades siguen funcionando como hasta ahora.

Ejercicio 3. Búsqueda por dos palabras

Tal y como está hecha la consulta para la búsqueda de links sólo se pueden localizar registros por una palabra clave. Piensa como podrías hacer una consulta que funcione con dos palabras separadas por un espacio e impleméntala.

Ejercicio 4. Most popular

Fíjate que el filtrado por Most Popular no funcionará sobre los registros resultantes de la búsqueda. Implementa esta función