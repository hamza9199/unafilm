import React, { useState } from "react";
import { BsArrowLeftCircleFill, BsArrowRightCircleFill } from "react-icons/bs";
import styles from "./css/Carusel.module.css";

export const Carousel = ({ data }) => {
  const [slide, setSlide] = useState(0);
  const [selectedTrailer, setSelectedTrailer] = useState(null);

  const nextSlide = () => {
    setSlide(slide === data.length - 1 ? 0 : slide + 1);
  };

  const prevSlide = () => {
    setSlide(slide === 0 ? data.length - 1 : slide - 1);
  };

  const getAutoplayUrl = (url) => {
    if (!url) return "";
    if (!url.includes("?")) return `${url}?autoplay=1`;
    return `${url}&autoplay=1`;
  };

  React.useEffect(() => {
    const interval = setInterval(() => {
      setSlide((prev) => (prev === data.length - 1 ? 0 : prev + 1));
    }, 5000);
    return () => clearInterval(interval);
  }, [data.length]);

  return (
    <>
      <div className={styles.carousel}>
        <BsArrowLeftCircleFill
          onClick={prevSlide}
          className={styles.arrowleft}
        />
        {data.map((item, idx) => (
          <div
            key={idx}
            className={
              slide === idx
                ? styles.slide
                : styles.slide + " " + styles["slide-hidden"]
            }
            style={{ width: "100%", height: "100%" }}
          >
            <a href={`/arhiva/film/${item.uuid}`}>
              <img
                src={item.src}
                alt={item.alt}
                style={{ width: "100%", height: "100%", objectFit: "cover" }}
              />
            </a>
            {slide === idx && (
              <div className={styles.slideContentWindow}>
                <h2 className={styles.slideTitle}>
                  <a
                    href={`/arhiva/film/${item.uuid}`}
                    style={{ color: "inherit", textDecoration: "none", fontWeight: "bold" }}
                  >
                    {item.title}
                  </a>
                </h2>
                <p className={styles.slideDesc}>
                  {
                    item.opis.replace(/[#*>]/g, "").length > 150
                      ? `${item.opis.replace(/[#*>]/g, "").substring(0, 150)}...`
                      : item.opis.replace(/[#*>]/g, "")
                  }
                </p>
                <div className={styles.slideButtonGroup}>
                  {item.trailerUrl && (
                    <button
                      className={styles.slideBtn}
                      onClick={() => setSelectedTrailer(item.trailerUrl)}
                    >
                      <svg
                        viewBox="-0.5 0 7 7"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="#000000"
                        width="30px"
                        height="20px"
                      >
                        <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                        <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                          <title>play [#1003]</title>
                          <desc>Created with Sketch.</desc>
                          <defs></defs>
                          <g
                            id="Page-1"
                            stroke="none"
                            strokeWidth="1"
                            fill="none"
                            fillRule="evenodd"
                          >
                            <g
                              id="Dribbble-Light-Preview"
                              transform="translate(-347.000000, -3766.000000)"
                              fill="#000000"
                            >
                              <g id="icons" transform="translate(56.000000, 160.000000)">
                                <path
                                  d="M296.494737,3608.57322 L292.500752,3606.14219 C291.83208,3605.73542 291,3606.25002 291,3607.06891 L291,3611.93095 C291,3612.7509 291.83208,3613.26444 292.500752,3612.85767 L296.494737,3610.42771 C297.168421,3610.01774 297.168421,3608.98319 296.494737,3608.57322"
                                  id="play-[#1003]"
                                ></path>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </button>
                  )}
                  <a
                    href={`/arhiva/film/${item.uuid}`}
                    className={
                      styles.slideBtn + " " + styles.slideBtnInfo
                    }
                  >
                    <svg
                      width="30px"
                      height="20px"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g
                        id="SVGRepo_tracerCarrier"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></g>
                      <g id="SVGRepo_iconCarrier">
                        {" "}
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM10.25 11C10.25 10.4477 10.6977 10 11.25 10H12.75C13.3023 10 13.75 10.4477 13.75 11V18C13.75 18.5523 13.3023 19 12.75 19H11.25C10.6977 19 10.25 18.5523 10.25 18V11ZM14 7C14 5.89543 13.1046 5 12 5C10.8954 5 10 5.89543 10 7C10 8.10457 10.8954 9 12 9C13.1046 9 14 8.10457 14 7Z"
                          fill="#000000"
                        ></path>{" "}
                      </g>
                    </svg>
                  </a>
                </div>
              </div>
            )}
          </div>
        ))}
        <BsArrowRightCircleFill
          onClick={nextSlide}
          className={styles.arrowright}
        />
      </div>

      <div className={styles.indicators}>
        {data.map((_, idx) => (
          <button
            key={idx}
            className={
              slide === idx
                ? styles.indicator
                : styles.indicator + " " + styles["indicator-inactive"]
            }
            onClick={() => setSlide(idx)}
          ></button>
        ))}
      </div>

      {selectedTrailer && (
        <div className={styles.selectedTrailer}>
          <div className={styles.iframeContainer}>
            <iframe
              width="700"
              height="400"
              src={getAutoplayUrl(selectedTrailer)}
              title="Trailer Video"
              frameBorder="0"
              allowFullScreen
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            ></iframe>
          </div>
          <button className={styles.closeButton} onClick={() => setSelectedTrailer(null)}>X</button>
        </div>
      )}
    </>
  );
};