# Git hooks de WARAS

## `pre-commit` — build automático de Vite

Este hook compila los assets de Vite (`npm run build`) **automáticamente** cada vez que
haces `git commit` con cambios en CSS/JS, y agrega `public/build/` al commit.

**Resultado:** nunca tienes que correr `npx vite build` a mano. Solo haces tu commit normal.

- Si el commit NO toca `resources/css/`, `resources/js/`, `vite.config.js`, `tailwind.config.js`
  ni `package.json` → no compila nada (commit instantáneo).
- Si SÍ los toca → compila y mete los assets actualizados en el mismo commit.

## Activación (ya está activo en esta máquina)

Git está configurado para usar esta carpeta como hooks:

```
git config core.hooksPath .githooks
```

Si clonas el repo en otra computadora, ejecuta ese mismo comando una vez para activarlo.
(En Windows, los hooks se ejecutan con Git Bash, que viene con Git para Windows.)
