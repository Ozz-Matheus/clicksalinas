# Proyecto Laravel + Filament

Panel administrativo para gestión de contenidos construido con un enfoque en simplicidad, rendimiento y arquitectura limpia.

## 🛠 Stack Tecnológico

* **Backend:** PHP 8.3, Laravel 13
* **Panel Administrativo:** Filament 5, Filament Shield (Roles/Permisos)
* **Frontend & Estilos:** TailwindCSS 4, Vite

---

## 🚀 Instalación y Entorno Local

1.  **Clonar proyecto e instalar dependencias:**
    ```bash
    git clone <repo>
    cd project
    composer install
    npm install
    ```

2.  **Configurar entorno y base de datos:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *(Configura las credenciales de tu base de datos en el archivo `.env`)*

3.  **Migrar, sembrar y enlazar storage:**
    ```bash
    php artisan migrate --seed
    php artisan storage:link
    ```

4.  **Levantar entorno:**
    ```bash
    composer run dev
    ```

**Acceso al panel:** La ruta de administración es `/admin`.

---

## 🏗 Guía para Desarrolladores (Arquitectura y Convenciones)

Para mantener la estabilidad y escalabilidad del sistema, el desarrollo debe regirse por las siguientes convenciones:

### Estructura Principal
* `app/Filament/Resources/`: Separación estricta por recurso (Pages, Schemas, Tables).
* `app/Services/`: Lógica compleja y reutilizable (ej. `MediaManager`, `IndexNowService`).
* `app/Policies/`: Gestión centralizada de permisos y accesos.

### Reglas de Implementación
1.  **Forms (Formularios):** Solo deben definir la UI y validar. Cualquier lógica pesada, procesamiento complejo o queries adicionales deben delegarse a los `Services`.
2.  **Uploads e Imágenes:** Toda la lógica de procesamiento (como la conversión automática a formato WebP) se centraliza en servicios. Evitar el procesamiento *inline* dentro de los Forms.
3.  **Slugs:** Se generan automáticamente utilizando el helper o servicio correspondiente (basado en `Str::slug()`).
4.  **Resources (Recursos Filament):** Deben cumplir con el Principio de Responsabilidad Única, mantener consistencia en el *naming* y evitar la duplicación de código.
5.  **Control de Acceso (Roles):** * `super_admin`: Acceso y control total del sistema.
    * `usuarios estándar`: Visualizan y gestionan únicamente el contenido de su propiedad