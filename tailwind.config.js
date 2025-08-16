import animate from "tailwindcss-animate";

export default {
    darkMode: ["class"],
    content: [
        "./pages/**/*.{js,ts,jsx,tsx,mdx}",
        "./components/**/*.{js,ts,jsx,tsx,mdx}",
        "./app/**/*.{js,ts,jsx,tsx,mdx}",
    ],
    theme: {
        extend: {
            colors: {
                background: "#FFFFFF",
                foreground: "#111827", // dark gray/black text
                card: {
                    DEFAULT: "#FFFFFF",
                    foreground: "#111827",
                },
                popover: {
                    DEFAULT: "#FFFFFF",
                    foreground: "#111827",
                },
                primary: {
                    DEFAULT: "#3B82F6", // bright blue (buttons, active elements)
                    foreground: "#FFFFFF", // white text on primary
                },
                secondary: {
                    DEFAULT: "#4A6CF7", // darker sidebar/footer blue
                    foreground: "#FFFFFF",
                },
                muted: {
                    DEFAULT: "#F3F4F6", // light gray background
                    foreground: "#6B7280", // muted text
                },
                accent: {
                    DEFAULT: "#E0EDFF", // very light blue (hover, highlights)
                    foreground: "#111827",
                },
                destructive: {
                    DEFAULT: "#EF4444", // red for errors/danger
                    foreground: "#FFFFFF",
                },
                border: "#D1D5DB", // light gray border
                input: "#E5E7EB", // input field background
                ring: "#3B82F6", // focus ring blue
                chart: {
                    "1": "#3B82F6",
                    "2": "#4A6CF7",
                    "3": "#E0EDFF",
                    "4": "#6B7280",
                    "5": "#EF4444",
                },
            },
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
            },
            screens: {
                xs: "375px",
            },
            animation: {
                marquee: "marquee var(--duration) linear infinite",
                "marquee-vertical": "marquee-vertical var(--duration) linear infinite",
            },
            keyframes: {
                marquee: {
                    from: {
                        transform: "translateX(0)",
                    },
                    to: {
                        transform: "translateX(calc(-100% - var(--gap)))",
                    },
                },
                "marquee-vertical": {
                    from: {
                        transform: "translateY(0)",
                    },
                    to: {
                        transform: "translateY(calc(-100% - var(--gap)))",
                    },
                },
            },
        },
    },
    plugins: [animate],
};