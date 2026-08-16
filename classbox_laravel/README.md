# 🚀 Classbox CMS - Versión Laravel 12

Bienvenido a la versión moderna y desacoplada de **Classbox CMS** construida sobre **Laravel 12**.

---

## 🔑 Credenciales Iniciales de Administrador

* **URL del Panel:** `http://127.0.0.1:8000/admin/login`
* **Usuario:** `renangalvan`
* **Contraseña:** `admin123`

---

## ⚡ Comandos Rápidos

### Iniciar el servidor local:
```bash
php artisan serve
```
El panel estará disponible en `http://127.0.0.1:8000/admin`.

### Ejecutar migraciones y datos iniciales:
```bash
php artisan migrate --seed
```

---

## 🔌 API REST v1 (Headless Endpoints)

Todos los endpoints entregan respuestas en formato JSON (`application/json`):

| Método | Endpoint | Descripción |
|---|---|---|
| `GET` | `/api/v1/posts` | Listar publicaciones/cursos (con filtros `search`, `category_id`, `instructors_only`, `limit`). |
| `GET` | `/api/v1/posts/{id}` | Detalle de publicación con adjuntos, fotos y autor. |
| `GET` | `/api/v1/categories` | Listado de categorías con total de publicaciones. |
| `GET` | `/api/v1/categories/{id}` | Detalle de categoría y sus cursos asociados. |
| `GET` | `/api/v1/menus` | Árbol jerárquico de menús y submenús. |
| `GET` | `/api/v1/testimonios` | Listado de testimonios (filtro `video=1` opcional). |
| `GET` | `/api/v1/client-data` | Datos corporativos, teléfonos, WhatsApp y redes sociales. |
| `POST` | `/api/v1/admisiones` | Enviar solicitud de matrícula/admisión desde formulario web. |
| `GET` | `/api/v1/graduaciones` | Listado de álbumes de graduaciones y sus galerías. |

---

## 🗄️ Conexión a Base de Datos MySQL (Opcional)

Por defecto viene configurado con SQLite para pruebas locales inmediatas. Si deseas conectarlo a tu servidor MySQL (XAMPP / Laragon / Servidor Remoto), edita el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=classbox_db
DB_USERNAME=root
DB_PASSWORD=
```
Luego ejecuta:
```bash
php artisan migrate:fresh --seed
```
