import Navbar from "@/components/navbar/navbar";
import Hero from "./hero";
import Features from "./features";
import FAQ from "./faq";
import Testimonials from "./testimonials";
import Footer from "./footer";
import Pricing from "./pricing";
import CTABanner from "./cta-banner";

export default function Home() {
    return (
        <>
            <Navbar />
            <main className="pt-16 xs:pt-20 sm:pt-24">
                <Hero />
                <Features />
                <Pricing />
                <FAQ />
                <Testimonials />
                <CTABanner />
                <Footer />
            </main>
        </>
    );
}