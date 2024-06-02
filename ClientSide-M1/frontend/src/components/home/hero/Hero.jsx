import React from "react"
import Heading from "../../common/heading/Heading"
import "./Hero.css"

const Hero = () => {
  return (
    <>
      <section className='hero'>
        <div className='container'>
          <div className='row'>
            <Heading subtitle='WELCOME TO THE SCHOOL OF KOSOVA' title='Best Education Expertise' />
            <p style={{ fontWeight: 'bold' }}>A trailblazing academic program.</p>
            <p style={{ fontWeight: 'bold' }}>A uniquely diverse community.</p>
            <p style={{ fontWeight: 'bold' }}>Rooted in the city we call home.</p>

            <div className='button'>
     
            </div>
          </div>
        </div>
      </section>
      <div className='margin'></div>
    </>
  )
}

export default Hero
