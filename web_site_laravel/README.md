# 🌐 Web CEFI - Versión Laravel 12 (`web_site_laravel`)

Frontend web independiente para el **Centro de Formación Integral (CEFI)**, construido con **Laravel 12** y plantillas **Blade**.

---

## ⚡ Comandos Rápidos

### Iniciar el servidor local del sitio web:
```bash
php artisan serve --port=8080
```
El sitio web estará disponible en **`http://127.0.0.1:8080`**.

---

## 🗺️ Mapa de Rutas Web

| URL | Nombre de Ruta | Descripción |
|---|---|---|
| `/` | `site.home` | Portada principal con carrusel, escuelas, cursos destacados y testimonios. |
| `/categoria/{id}` | `site.category` | Catálogo de cursos filtrados por escuela/categoría. |
| `/curso/{id}` | `site.course.show` | Ficha técnica del curso con visor de PDFs, videos de YouTube y botón de WhatsApp. |
| `/graduaciones` | `site.graduaciones` | Galería de ceremonias de graduación. |
| `/graduacion/{id}` | `site.graduacion.show` | Detalle del álbum de graduación con visor de fotos y video. |
| `/quienes-somos` | `site.about` | Información institucional de CEFI. |
| `/docentes` | `site.team` | Equipo de instructores y docentes. |
| `/testimonios` | `site.testimonials` | Muro de opiniones de egresados y estudiantes. |
| `/contacto` | `site.contact` | Formulario de matrícula/admisión protegido contra CSRF y datos de contacto. |

---

## 🔗 Integración con Classbox CMS

Este sitio web consume directamente la misma base de datos y archivos multimedia gestionados por **Classbox Laravel**. Todo cambio realizado en el panel administrativo (`http://127.0.0.1:8000/admin`) se refleja inmediatamente en esta web.
