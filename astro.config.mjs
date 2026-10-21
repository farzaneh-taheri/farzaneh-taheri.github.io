// @ts-check
import { defineConfig } from "astro/config";
import tailwindcss from "@tailwindcss/vite";

// https://astro.build/config
export default defineConfig({
  site: "https://farzaneh-taheri.github.io",
  //base: "/farta-site",
  trailingSlash: "always",
  vite: {
    plugins: [tailwindcss()],
  },
});
