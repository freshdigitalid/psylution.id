import Hero from "./hero";
import Features from "./features";
import FAQ from "./faq";
import Testimonials from "./testimonials";
import Pricing from "./pricing";
import CTABanner from "./cta-banner";
import Layout from "@/layouts/layout";
import StatsBand from "./stats-band";
import ServicesGrid from "./services-grid";
import BookNow from "./book-now";
import WhatTheySay from "./what-they-say";

export default function Home() {
  return (
    <Layout>
      <Hero />
      <StatsBand />
      <ServicesGrid />
      <BookNow />
      <WhatTheySay />
      <Features />
      <Pricing />
      <FAQ />
      <Testimonials />
      <CTABanner />
    </Layout>
  );
}