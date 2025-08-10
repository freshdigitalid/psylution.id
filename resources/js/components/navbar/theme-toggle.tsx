import { MoonIcon, SunIcon } from "lucide-react";
import { useAppearance } from "../../hooks/use-appearance";
import { useEffect, useState } from "react";
import { Button } from "../ui/button";

const ThemeToggle = () => {
    const { appearance, updateAppearance } = useAppearance();
    const [mounted, setMounted] = useState(false);

    useEffect(() => {
        setMounted(true);
    }, []);

    if (!mounted) {
        return <Button variant="outline" size="icon" />;
    }

    const isDark = appearance === "dark" || (appearance === "system" && window.matchMedia('(prefers-color-scheme: dark)').matches);

    return (
        <Button
            variant="outline"
            size="icon"
            onClick={() => updateAppearance(isDark ? "light" : "dark")}
        >
            {isDark ? <SunIcon /> : <MoonIcon />}
        </Button>
    );
};

export default ThemeToggle;