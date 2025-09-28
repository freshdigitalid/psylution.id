import { MoonIcon, SunIcon } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useAppearance } from '../../hooks/use-appearance';
import { Button } from '../ui/button';

const ThemeToggle = () => {
    const { appearance, updateAppearance } = useAppearance();
    const [mounted, setMounted] = useState(false);

    useEffect(() => {
        setMounted(true);
    }, []);

    if (!mounted) {
        return <Button variant="outline" size="icon" />;
    }

    const isDark = appearance === 'dark' || (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

    const handleToggle = () => {
        const newMode = isDark ? 'light' : 'dark';
        updateAppearance(newMode);
    };

    return (
        <Button variant="outline" size="icon" onClick={handleToggle} title={`Switch to ${isDark ? 'light' : 'dark'} mode`}>
            {isDark ? <SunIcon className="h-4 w-4" /> : <MoonIcon className="h-4 w-4" />}
        </Button>
    );
};

export default ThemeToggle;
