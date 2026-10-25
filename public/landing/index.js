class LoginLink {
    static LABELS = ["login", "mulai bergabung"];
    #url;
    constructor(url) {
        this.#url = url;
    }
    /** Tombol/tautan yang harus membuka halaman login. */
    findTargets(root = document) {
        const marked = [...root.querySelectorAll("[data-login]")];
        const byText = [
            ...root.querySelectorAll(
                'a, button, [role="button"], .btn, div, span, p',
            ),
        ]
            .filter((el) => {
                const own = [...el.childNodes]
                    .filter((n) => n.nodeType === 3)
                    .map((n) => n.textContent)
                    .join("")
                    .trim()
                    .toLowerCase();
                return (
                    LoginLink.LABELS.includes(own) ||
                    (el.children.length === 0 &&
                        LoginLink.LABELS.includes(
                            el.textContent.trim().toLowerCase(),
                        ))
                );
            })
            // pilih elemen yang dapat diklik (bagian dari tombol), bukan teks "Login" di judul form
            .map((el) => el.closest('a, button, [role="button"], .btn') || el)
            .filter((el) => !el.closest("form"));
        return [...new Set([...marked, ...byText])];
    }
    bind() {
        this.findTargets().forEach((el) => {
            el.style.cursor = "pointer";
            if (!el.matches("a, button")) {
                el.setAttribute("role", "button");
                el.tabIndex = 0;
            }
            const go = (e) => {
                e.preventDefault();
                window.location.href = this.#url;
            };
            el.addEventListener("click", go);
            el.addEventListener("keydown", (e) => {
                if (e.key === "Enter" || e.key === " ") go(e);
            });
        });
    }
}

class MenuScroller {
    static MENU = {
        beranda: ["beranda", "top", "home"],
        tentang: ["tentang"],
        fitur: ["fitur"],
        kontak: ["kontak"],
    };
    #items = [];
    bind() {
        document.querySelectorAll("a, button, p, span, li").forEach((el) => {
            if (el.children.length > 0) return;
            const key = el.textContent.trim().toLowerCase();
            if (!(key in MenuScroller.MENU)) return;
            const section = this.#section(key);
            if (!section && key !== "beranda") return;
            this.#items.push({ el, section });
            el.style.cursor = "pointer";
            el.addEventListener("click", (e) => {
                e.preventDefault();
                (section || document.documentElement).scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
                if (!section) window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    }
    #section(key) {
        for (const id of MenuScroller.MENU[key]) {
            const s = document.getElementById(id);
            if (s) return s;
        }
        return null;
    }
}

(function start() {
    const script = document.currentScript;
    const url = script?.dataset.loginUrl || "login.html";
    const run = () => {
        new LoginLink(url).bind();
        new MenuScroller().bind();
    };
    if (document.readyState === "loading")
        document.addEventListener("DOMContentLoaded", run);
    else run();
})();
