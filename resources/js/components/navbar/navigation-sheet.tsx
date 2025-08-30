import { Button } from "@/components/ui/button";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";
import { Menu } from "lucide-react";
import { NavMenu } from "./nav-menu";
import AppLogoIcon from "../app-logo-icon";

export const NavigationSheet = () => {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button variant="outline" size="icon" className="rounded-full">
                    <Menu />
                </Button>
            </SheetTrigger>
            <SheetContent className="p-4 gap-0 overflow-y-auto max-h-screen">
                <AppLogoIcon width={124} height={32} className="h-full w-auto object-contain" />
                <NavMenu orientation="vertical" />

                <div className="mt-8 space-y-4">
                    <Button variant="outline" className="w-full sm:hidden">
                        Sign In
                    </Button>
                    <Button className="w-full xs:hidden">Get Started</Button>
                </div>
            </SheetContent>
        </Sheet>
    );
};