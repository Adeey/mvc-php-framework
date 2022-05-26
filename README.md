# Installation
1. Setup your database in config file: `config/db.php`
1. Seed your database with test data: ``php seeder.php``
1. User was created by seeder login: admin | password: admin

# Jak to dziala?
1. To jest MVC, mamy plik 'controllers', tam mozna umiesic swoj controller i korzystac z niego przez `domain.com/index.php/controller/method/param1/param2/...`
`Controller::method($param1, $param2)`
3. W kontroleru w construct mozna zaladowac model przez `$this->load('modelName')`, model trzeba umiescic w plik model i nazwac jak klasu
4. Mozna stworzyc swoj model i ladowac go, wszystkie modeli sa dostepne przez `$this->modelName->method()`
5. Zeby zalodawac view trzeba napisac `$this->view('plik/file')`, to view mozna dodac swoje zmienne oni beda dosptene w view poprzez `$items`, czyli jezeli napiszemy cos takiego typu `$this->view('products/edit', ['product' => $product])` to ten product bedzie dostepny przez `$items['product]` 
6. W pliku 'core' znajduje sie 'MappingController', to jest klasa 'posredniczaca' czyli najpierw bedzie Request przechodiz przez klasy wymienone w funkcji, teraz tam znajduje sie tylko 'auth',
ta klasa musi znajdowac sie w pliku mapServices i implementowac interfejs z funkcja `run()`, jezeli ta funkcja zwroci `true` to wszysto ok i Request pojdzie dalej, jezeli zwroci `false` to na tym sie konczy

# UWAGA
1. Zrzut bazy danych. - nie realizowalem tego, ja bym to zrobilem poprostu przez ``exec`` ale robilem na lokalnym srodowisku i nie moge robic zrzutow
1. Formularz rejestracji użytkownika. - nie robilem formularz rejestracji bo mysle ze to jest poprostu juz trata czasu
