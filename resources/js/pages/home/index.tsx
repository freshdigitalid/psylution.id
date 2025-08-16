import Hero from "./hero";
import Features from "./features";
import FAQ from "./faq";
import Testimonials from "./testimonials";
import Pricing from "./pricing";
import CTABanner from "./cta-banner";
import Layout from "@/layouts/layout";

export default function Home() {
    return (
        <Layout>
            <Hero />
            <Features />
            <Pricing />
            <FAQ />
            <Testimonials />
            <CTABanner />
        </Layout>
    );
}