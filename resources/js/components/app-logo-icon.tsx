import { ImgHTMLAttributes } from "react";

export default function AppLogoIcon(props: ImgHTMLAttributes<HTMLImageElement>) {
    return (
        <img
            src="/logo/logo.png"
            alt="Psylution Logo"
            {...props}
        />
    );
}